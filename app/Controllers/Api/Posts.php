<?php

namespace App\Controllers\Api;

// Use ResourceController instead of BaseController for specialized APIs
use CodeIgniter\RESTful\ResourceController;
use App\Models\PostModel;

class Posts extends ResourceController
{
    // Forces all endpoints in this class to output strict JSON
    protected $format = 'json'; 

    /**
     * Return all blog articles
     * GET /api/posts
     */
    public function index()
    {
        $model = new PostModel();
        $posts = $model->findAll();

        if (empty($posts)) {
            return $this->failNotFound('No articles found matching query');
        }

        return $this->respond($posts);
    }

    /**
     * Return a single blog post by database row identity
     * GET /api/posts/{id}
     */
    public function show($id = null)
    {
        $model = new PostModel();
        $post = $model->find($id);

        if (!$post) {
            return $this->failNotFound('The requested blog post entry could not be found.');
        }

        return $this->respond($post);
    }
}

