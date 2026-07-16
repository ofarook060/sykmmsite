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
        
        // Handle image upload
        $imagePath = null;
        $file = $this->request->getFile('images');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/properties/', $newName);
            $imagePath = '/uploads/properties/' . $newName;
        }

        $data = [
            'title'           => $this->request->getVar('title'),
            'location'        => $this->request->getVar('location'),
            'price'           => $this->request->getVar('price'),
            'size'            => $this->request->getVar('size'),
            'rooms'           => $this->request->getVar('rooms'),
            'masterBedrooms'  => $this->request->getVar('masterBedrooms'),
            'bedrooms'        => $this->request->getVar('bedrooms'),
            'bathrooms'       => $this->request->getVar('bathrooms'),
            'description'     => $this->request->getVar('description'),
            'facebookPost'    => $this->request->getVar('facebookPost'),
            'images'          => $imagePath
        ];

        if ($model->save($data)) {
            return $this->respondCreated(['status' => 'success', 'message' => 'Property created']);
        }
        return $this->fail($model->errors());
    }

    public function update($id = null)
    {
        $model = new PropertyModel();
        
        $property = $model->find($id);
        if (!$property) return $this->failNotFound('Property not found');

        $imagePath = $property['images'];
        $file = $this->request->getFile('images');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/properties/', $newName);
            $imagePath = '/uploads/properties/' . $newName;
        }

        $data = [
            'title'           => $this->request->getVar('title') ?? $property['title'],
            'location'        => $this->request->getVar('location') ?? $property['location'],
            'price'           => $this->request->getVar('price') ?? $property['price'],
            'size'            => $this->request->getVar('size') ?? $property['size'],
            'rooms'           => $this->request->getVar('rooms') ?? $property['rooms'],
            'masterBedrooms'  => $this->request->getVar('masterBedrooms') ?? $property['masterBedrooms'],
            'bedrooms'        => $this->request->getVar('bedrooms') ?? $property['bedrooms'],
            'bathrooms'       => $this->request->getVar('bathrooms') ?? $property['bathrooms'],
            'description'     => $this->request->getVar('description') ?? $property['description'],
            'facebookPost'    => $this->request->getVar('facebookPost') ?? $property['facebookPost'],
            'images'          => $imagePath
        ];

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
