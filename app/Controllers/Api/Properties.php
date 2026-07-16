<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PropertyModel;

class Properties extends ResourceController
{
    protected $format = 'json'; 

    public function index()
    {
        $this->response->setContentType('application/json');
        $model = new PropertyModel();
        return $this->respond($model->findAll());
    }

    public function show($id = null)
    {
        $model = new PropertyModel();
        $property = $model->find($id);
        if (!$property) return $this->failNotFound('Property not found');
        return $this->respond($property);
    }

    public function create()
    {
        $model = new PropertyModel();
        $data = $this->request->getJSON(true);
        if ($model->save($data)) {
            return $this->respondCreated(['status' => 'success', 'message' => 'Property created']);
        }
        return $this->fail($model->errors());
    }

    public function update($id = null)
    {
        $model = new PropertyModel();
        $data = $this->request->getJSON(true);
        if ($model->update($id, $data)) {
            return $this->respond(['status' => 'success', 'message' => 'Property updated']);
        }
        return $this->fail($model->errors());
    }

    public function delete($id = null)
    {
        $model = new PropertyModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['status' => 'success', 'message' => 'Property deleted']);
        }
        return $this->fail('Failed to delete');
    }
}
