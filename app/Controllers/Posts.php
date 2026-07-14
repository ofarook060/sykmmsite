<?php
namespace App\Controllers;
use App\Models\PostModel;
// 1. Import the API Response trait
use CodeIgniter\API\ResponseTrait;

class Posts extends BaseController {
    // 2. Enable the trait inside your controller class
    use ResponseTrait;

    // Public: List all blog posts
    public function index() {
        $model = new PostModel();
        $posts = $model->findAll();

        // 3. Content Negotiation for Index Listings
        if ($this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json' || $this->request->getGet('format') === 'json') {
            return $this->respond($posts);
        }

        $data['posts'] = $posts;
        return view('posts/index', $data);
    }

    // Public: View a single post
    public function view($id) {
        $model = new PostModel();
        $post = $model->find($id);

        if (!$post) {
            // 4. API 404 response for mobile applications vs Standard fallback for browsers
            if ($this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json' || $this->request->getGet('format') === 'json') {
                return $this->failNotFound('Blog post not found');
            }
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 5. Content Negotiation for Single Article View
        if ($this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json' || $this->request->getGet('format') === 'json') {
            return $this->respond($post);
        }

        $data['post'] = $post;
        return view('posts/view', $data);
    }

    // Admin Only: Create a new blog post
    public function create() {
        // Detect if request originates from a JSON environment (like React Native)
        $isJsonRequest = $this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json';

        // Protect route using session logic (Only enforce this browser redirection for web users)
        if (!$isJsonRequest && !session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in to manage posts.');
        }

        if ($this->request->is('post')) {
            $model = new PostModel();
            $imageName = null;

            // Handle optional single image upload (Multi-part content form upload)
            $file = $this->request->getFile('blog_image');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $imageName = $file->getRandomName();
                $targetPath = ROOTPATH . 'public/uploads/blog/';
                $file->move($targetPath, $imageName);

                // Image Optimization & Auto-Resize
                \Config\Services::image()
                    ->withFile($targetPath . $imageName)
                    ->resize(800, 500, true, 'width')
                    ->save($targetPath . $imageName);
            }

            // Using getVar() handles data seamlessly from both JSON request bodies and standard $_POST fields
            $postData = [
                'title'   => $this->request->getVar('title'),
                'content' => $this->request->getVar('content'),
                'images'  => $imageName
            ];

            if ($model->save($postData)) {
                if ($isJsonRequest) {
                    return $this->respondCreated(['status' => true, 'message' => 'Post published successfully!']);
                }
                return redirect()->to('/posts')->with('success', 'Post published successfully!');
            }

            if ($isJsonRequest) {
                return $this->fail('Failed to save the blog post entry.');
            }
        }

        return view('posts/create');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> c65a99473a8de833fb9f3ce23cb1f540eb467c37
