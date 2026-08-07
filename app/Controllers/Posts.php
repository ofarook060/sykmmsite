<?php

namespace App\Controllers;

use App\Models\PostModel;
use CodeIgniter\API\ResponseTrait;

class Posts extends BaseController
{
    use ResponseTrait;

    private function normalizeAttachments($stored): array
    {
        if (empty($stored)) {
            return [];
        }

        $decoded = json_decode($stored, true);
        if (is_array($decoded)) {
            return array_map(function ($item) {
                if (is_string($item)) {
                    return [
                        'path' => $item,
                        'name' => basename($item),
                    ];
                }
                return [
                    'path' => $item['path'] ?? '',
                    'name' => $item['name'] ?? basename($item['path'] ?? ''),
                ];
            }, $decoded);
        }

        return [[
            'path' => $stored,
            'name' => basename($stored),
        ]];
    }

    private function moveUploadedFiles(array $fieldNames, string $targetDir, string $publicPrefix = '/uploads/'): array
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

    // Public: List all blog posts
    public function index()
    {
        $model = new PostModel();
        $posts = $model->findAll();

        // Enforce JSON for API routes
        if (strpos($this->request->getPath(), 'api/') === 0 || $this->request->isAJAX() || $this->request->getGet('format') === 'json') {
            return $this->respond($posts);
        }

        $data['posts'] = $posts;
        return view('posts/index', $data);
    }

    // Public: View a single post for web visitors
    public function view($id)
    {
        $model = new PostModel();
        $data['post'] = $model->find($id);

        if (!$data['post']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('posts/view', $data);
    }

    // Admin/Mobile: Create a new blog post
    public function create()
    {
        $isJsonRequest = $this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json';

        if (!$isJsonRequest && !session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login');
        }

        if ($this->request->is('post')) {
            $model = new PostModel();
            $uploadedFiles = $this->moveUploadedFiles(['files', 'attachments', 'images'], ROOTPATH . 'public/uploads/blog/', '/uploads/blog/');
            $imagePath = !empty($uploadedFiles) ? json_encode($uploadedFiles) : null;

            $postData = [
                'title'   => $this->request->getVar('title'),
                'content' => $this->request->getVar('content'),
                'images'  => $imagePath,
            ];

            if ($model->save($postData)) {
                if ($isJsonRequest) {
                    return $this->respondCreated(['status' => true, 'message' => 'Post created successfully']);
                }
                return redirect()->to('/posts')->with('success', 'Post published successfully!');
            }

            if ($isJsonRequest) {
                return $this->fail('Failed to save post');
            }
        }

        return view('posts/create');
    }

    // Admin: Edit a blog post
    public function edit($id = null)
    {
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login');
        }

        $model = new PostModel();
        $post = $model->find($id);
        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('post')) {
            $existingFiles = $this->normalizeAttachments($post['images']);

            $removePaths = $this->request->getPost('remove');
            if (is_array($removePaths) && !empty($removePaths)) {
                $existingFiles = array_values(array_filter($existingFiles, function ($item) use ($removePaths) {
                    return !in_array($item['path'], $removePaths, true);
                }));
                foreach ($removePaths as $removePath) {
                    $absPath = ROOTPATH . 'public' . $removePath;
                    if (is_file($absPath)) {
                        unlink($absPath);
                    }
                }
            }

            $uploadedFiles = $this->moveUploadedFiles(['files', 'attachments', 'images'], ROOTPATH . 'public/uploads/blog/', '/uploads/blog/');
            $mergedFiles = array_merge($existingFiles, $uploadedFiles);
            $imagePath = !empty($mergedFiles) ? json_encode($mergedFiles) : null;

            $postData = [
                'id'      => $id,
                'title'   => $this->request->getVar('title'),
                'content' => $this->request->getVar('content'),
                'images'  => $imagePath,
            ];

            if ($model->save($postData)) {
                return redirect()->to('/admin/dashboard')->with('success', 'Post updated successfully!');
            }
        }

        return view('posts/edit', ['post' => $post]);
    }

    // Admin: Delete a blog post
    public function delete($id = null)
    {
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login');
        }

        $model = new PostModel();
        $model->delete($id);
        return redirect()->to('/admin/dashboard')->with('success', 'Post deleted!');
    }

    // Admin/Mobile: Update an existing post
    public function update($id = null)
    {

        $model = new PostModel();

        $post = $model->find($id);
        if (!$post) {
            return $this->failNotFound('Post not found');
        }

        $existingFiles = $this->normalizeAttachments($post['images']);
        $uploadedFiles = $this->moveUploadedFiles(['files', 'attachments', 'images'], ROOTPATH . 'public/uploads/blog/', '/uploads/blog/');
        $imagePath = !empty($uploadedFiles) ? json_encode(array_merge($existingFiles, $uploadedFiles)) : $post['images'];

        $postData = [
            'id'      => $id,
            'title'   => $this->request->getVar('title') ?? $post['title'],
            'content' => $this->request->getVar('content') ?? $post['content'],
            'images'  => $imagePath,
        ];

        if ($model->save($postData)) {
            return $this->respond(['status' => true, 'message' => 'Post updated successfully']);
        }

        return $this->fail('Failed to update post');
    }
}
