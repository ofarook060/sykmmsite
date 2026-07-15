<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PostModel;

class Posts extends ResourceController
{
    protected $format = 'json'; 

    public function index()
    {
        $model = new PostModel();
        return $this->respond($model->findAll());
    }

    public function show($id = null)
    {
        $model = new PostModel();
        $post = $model->find($id);
        if (!$post) return $this->failNotFound('Post not found');
        return $this->respond($post);
    }

    public function create()
    {
        $model = new PostModel();
        $data = $this->request->getJSON(true);
        if ($model->save($data)) {
            return $this->respondCreated(['status' => 'success', 'message' => 'Post created']);
        }
        return $this->fail($model->errors());
    }

    public function update($id = null)
    {
        $model = new PostModel();
        $data = $this->request->getJSON(true);
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
