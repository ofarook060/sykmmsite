<?php

namespace App\Controllers\Api;

use App\Models\PropertyModel;
use CodeIgniter\RESTful\ResourceController;

class Properties extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $model = new PropertyModel();
        $properties = $model->findAll();

        // Decode the images JSON string into an array for every property output
        foreach ($properties as &$p) {
            $p['images'] = !empty($p['images']) ? json_decode($p['images'], true) : [];
        }

        return $this->respond($properties);
    }

    public function show($id = null)
    {
        $model = new PropertyModel();
        $property = $model->find($id);
        
        if (!$property) {
            return $this->failNotFound('Property not found');
        }

        // Convert raw JSON text from DB into a standard API response array
        $property['images'] = !empty($property['images']) ? json_decode($property['images'], true) : [];
        
        return $this->respond($property);
    }

    public function create()
    {
        $model = new PropertyModel();
        $uploadedImages = [];

        // Support both single file and multi-file keys via mobile API requests
        if ($files = $this->request->getFiles()) {
            if (isset($files['images'])) {
                $imagesField = $files['images'];
                if (is_array($imagesField)) {
                    foreach ($imagesField as $img) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $img->move(ROOTPATH . 'public/uploads/', $newName);
                            $uploadedImages[] = '/uploads/' . $newName;
                        }
                    }
                } else {
                    if ($imagesField->isValid() && !$imagesField->hasMoved()) {
                        $newName = $imagesField->getRandomName();
                        $imagesField->move(ROOTPATH . 'public/uploads/', $newName);
                        $uploadedImages[] = '/uploads/' . $newName;
                    }
                }
            }
        }

        $imageJsonString = !empty($uploadedImages) ? json_encode($uploadedImages) : null;

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
            'images'          => $imageJsonString,
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
        
        if (!$property) {
            return $this->failNotFound('Property not found');
        }

        // Note: PHP natively discards multipart/form-data files sent on standard PUT requests.
        // For mobile clients uploading images during updates, tell them to send a POST request 
        // targeting your endpoint with a spoofed header or use normal POST methods.
        $uploadedImages = [];
        if ($files = $this->request->getFiles()) {
            if (isset($files['images'])) {
                $imagesField = $files['images'];
                if (is_array($imagesField)) {
                    foreach ($imagesField as $img) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $img->move(ROOTPATH . 'public/uploads/', $newName);
                            $uploadedImages[] = '/uploads/' . $newName;
                        }
                    }
                } else {
                    if ($imagesField->isValid() && !$imagesField->hasMoved()) {
                        $newName = $imagesField->getRandomName();
                        $imagesField->move(ROOTPATH . 'public/uploads/', $newName);
                        $uploadedImages[] = '/uploads/' . $newName;
                    }
                }
            }
        }

        // Merge incoming images with current images if files are provided
        if (!empty($uploadedImages)) {
            $existing = !empty($property['images']) ? json_decode($property['images'], true) : [];
            $imagePath = json_encode(array_merge(is_array($existing) ? $existing : [], $uploadedImages));
        } else {
            $imagePath = $property['images'];
        }

        // Using getRawInput() as a safeguard logic for handling raw API request inputs
        $rawInput = $this->request->getRawInput();

        $data = [
            'title'           => $this->request->getVar('title') ?? ($rawInput['title'] ?? $property['title']),
            'location'        => $this->request->getVar('location') ?? ($rawInput['location'] ?? $property['location']),
            'price'           => $this->request->getVar('price') ?? ($rawInput['price'] ?? $property['price']),
            'size'            => $this->request->getVar('size') ?? ($rawInput['size'] ?? $property['size']),
            'rooms'           => $this->request->getVar('rooms') ?? ($rawInput['rooms'] ?? $property['rooms']),
            'masterBedrooms'  => $this->request->getVar('masterBedrooms') ?? ($rawInput['masterBedrooms'] ?? $property['masterBedrooms']),
            'bedrooms'        => $this->request->getVar('bedrooms') ?? ($rawInput['bedrooms'] ?? $property['bedrooms']),
            'bathrooms'       => $this->request->getVar('bathrooms') ?? ($rawInput['bathrooms'] ?? $property['bathrooms']),
            'description'     => $this->request->getVar('description') ?? ($rawInput['description'] ?? $property['description']),
            'facebookPost'    => $this->request->getVar('facebookPost') ?? ($rawInput['facebookPost'] ?? $property['facebookPost']),
            'images'          => $imagePath,
        ];

        if ($model->update($id, $data)) {
            return $this->respond(['status' => 'success', 'message' => 'Property updated']);
        }
        return $this->fail($model->errors());
    }

    public function delete($id = null)
    {
        $model = new PropertyModel();
        
        if (!$model->find($id)) {
            return $this->failNotFound('Property not found');
        }

        if ($model->delete($id)) {
            return $this->respondDeleted(['status' => 'success', 'message' => 'Property deleted']);
        }
        return $this->fail('Failed to delete');
    }
}
