<?php

namespace App\Controllers\Api;

use App\Models\PostModel;
use CodeIgniter\RESTful\ResourceController;

class Posts extends ResourceController
{
    protected $format = 'json';

    private function moveUploadedFiles(array $fieldNames, string $targetDir, string $publicPrefix = '/uploads/blog/'): array
    {
        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $uploaded = [];
        $files = $this->request->getFiles();

        foreach ($fieldNames as $fieldName) {
            if (! isset($files[$fieldName])) {
                continue;
            }

            $field = $files[$fieldName];
            $items = is_array($field) ? $field : [$field];

            foreach ($items as $file) {
                if (! $file->isValid() || $file->hasMoved()) {
                    continue;
                }
                $newName = $file->getRandomName();
                $file->move($targetDir, $newName);
                $uploaded[] = [
                    'path' => $publicPrefix . $newName,
                    'name' => $file->getClientName(),
                ];
            }
        }

        return $uploaded;
    }

    public function index()
    {
        $this->response->setContentType('application/json');
        $model = new PostModel();
        return $this->respond($model->findAll());
    }

    public function show($id = null)
    {
        $model = new PostModel();
        $post = $model->find($id);
        if (!$post) {
            return $this->failNotFound('Post not found');
        }
        return $this->respond($post);
    }

    public function create()
    {
        $model = new PostModel();

        $attachments = $this->moveUploadedFiles(['files', 'attachments', 'images'], ROOTPATH . 'public/uploads/blog/', '/uploads/blog/');
        $imagePath = !empty($attachments) ? json_encode($attachments) : null;

        $data = [
            'title'   => $this->request->getVar('title'),
            'content' => $this->request->getVar('content'),
            'images'  => $imagePath,
        ];

        if ($model->save($data)) {
            return $this->respondCreated(['status' => 'success', 'message' => 'Post created']);
        }
        return $this->fail($model->errors());
    }

    public function update($id = null)
    {
        $model = new PostModel();

        $post = $model->find($id);
        if (!$post) {
            return $this->failNotFound('Post not found');
        }

        $uploaded = $this->moveUploadedFiles(['files', 'attachments', 'images'], ROOTPATH . 'public/uploads/blog/', '/uploads/blog/');
        $existing = [];
        if (!empty($post['images'])) {
            $decoded = json_decode($post['images'], true);
            if (is_array($decoded)) {
                $existing = $decoded;
            }
        }

        $imagePath = !empty($uploaded) ? json_encode(array_merge($existing, $uploaded)) : $post['images'];

        $data = [
            'title'   => $this->request->getVar('title') ?? $post['title'],
            'content' => $this->request->getVar('content') ?? $post['content'],
            'images'  => $imagePath,
        ];

        if ($model->update($id, $data)) {
            return $this->respond(['status' => 'success', 'message' => 'Post updated']);
        }
        return $this->fail($model->errors());
    }

    public function delete($id = null)
    {
        $model = new PostModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['status' => 'success', 'message' => 'Post deleted']);
        }
        return $this->fail('Failed to delete');
    }
}
