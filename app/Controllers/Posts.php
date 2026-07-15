<?php
namespace App\Controllers;
use App\Models\PostModel;

class Posts extends BaseController {

    // Public: List all blog posts for web visitors
    public function index() {
        $model = new PostModel();
        $data['posts'] = $model->findAll();
        return view('posts/index', $data);
    }

    // Public: View a single post for web visitors
    public function view($id) {
        $model = new PostModel();
        $data['post'] = $model->find($id);

        if (!$data['post']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('posts/view', $data);
    }

    // Admin Only: Create a new blog post via web dashboard
    public function create() {
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in to manage posts.');
        }

        if ($this->request->is('post')) {
            $model = new PostModel();
            $imageName = null;

            $file = $this->request->getFile('blog_image');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $imageName = $file->getRandomName();
                $targetPath = ROOTPATH . 'public/uploads/blog/';
                $file->move($targetPath, $imageName);

                \Config\Services::image()
                    ->withFile($targetPath . $imageName)
                    ->resize(800, 500, true, 'width')
                    ->save($targetPath . $imageName);
            }

            $model->save([
                'title'   => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'images'  => $imageName
            ]);

            return redirect()->to('/posts')->with('success', 'Post published successfully!');
        }

        return view('posts/create');
    }
}

