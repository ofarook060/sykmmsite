<?php

namespace App\Controllers\Api;

use App\Models\PostModel;
use CodeIgniter\RESTful\ResourceController;

class Posts extends ResourceController
{
    protected $format = 'json';

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

        // Handle image upload
        $imagePath = null;
        $file = $this->request->getFile('images');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            // Ensure this directory exists in the backend
            $file->move(ROOTPATH . 'public/uploads/blog/', $newName);
            $imagePath = '/uploads/blog/' . $newName;
        }

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

        $imagePath = $post['images']; // Keep existing
        $file = $this->request->getFile('images');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/blog/', $newName);
            $imagePath = '/uploads/blog/' . $newName;
        }

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
