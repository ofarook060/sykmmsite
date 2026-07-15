<?php
namespace App\Controllers;
use App\Models\PostModel;
use CodeIgniter\API\ResponseTrait;

class Posts extends BaseController {
    use ResponseTrait;

    // Public: List all blog posts
    public function index() {
        $model = new PostModel();
        $posts = $model->findAll();

        if ($this->request->isAJAX() || $this->request->getGet('format') === 'json') {
            return $this->respond($posts);
        }

        $data['posts'] = $posts;
        return view('posts/index', $data);
    }

    // Admin/Mobile: Create a new blog post
    public function create() {
        $isJsonRequest = $this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json';

        if (!$isJsonRequest && !session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login');
        }

        if ($this->request->is('post')) {
            $model = new PostModel();
            
            // New Image handling logic for mobile multipart/form-data
            $imagePath = null;
            $file = $this->request->getFile('images'); // Matches key in Mobile App's FormData
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $targetPath = ROOTPATH . 'public/uploads/blog/';
                $file->move($targetPath, $newName);
                $imagePath = '/uploads/blog/' . $newName;
            }

            $postData = [
                'title'   => $this->request->getVar('title'),
                'content' => $this->request->getVar('content'),
                'images'  => $imagePath
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

    // Admin/Mobile: Update an existing post
    public function update($id = null) {
        $model = new PostModel();
        
        $post = $model->find($id);
        if (!$post) return $this->failNotFound('Post not found');

        $imagePath = $post['images']; // Keep existing
        $file = $this->request->getFile('images');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $targetPath = ROOTPATH . 'public/uploads/blog/';
            $file->move($targetPath, $newName);
            $imagePath = '/uploads/blog/' . $newName;
        }

        $postData = [
            'id'      => $id,
            'title'   => $this->request->getVar('title') ?? $post['title'],
            'content' => $this->request->getVar('content') ?? $post['content'],
            'images'  => $imagePath
        ];

        if ($model->save($postData)) {
            return $this->respond(['status' => true, 'message' => 'Post updated successfully']);
        }
        
        return $this->fail('Failed to update post');
    }
}

