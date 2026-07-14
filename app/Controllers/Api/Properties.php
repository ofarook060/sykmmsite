<?php

namespace App\Controllers\Api;

// Use ResourceController instead of BaseController for RESTful APIs
use CodeIgniter\RESTful\ResourceController;
use App\Models\PropertyModel;

class Properties extends ResourceController
{
    // Tells the ResourceController to return JSON automatically
    protected $format = 'json'; 

    /**
     * Return all properties
     * GET /api/properties
     */
    public function index()
    {
        $model = new PropertyModel();
        $properties = $model->findAll();

        if (empty($properties)) {
            return $this->failNotFound('No properties found');
        }

        return $this->respond($properties);
    }

    /**
     * Return a single property details
     * GET /api/properties/{id}
     */
    public function show($id = null)
    {
        $model = new PropertyModel();
        $property = $model->find($id);

        if (!$property) {
            return $this->failNotFound('Property not found');
        }

        // Auto decode image strings if present
        if (!empty($property['images'])) {
            $property['images'] = json_decode($property['images']);
        }

        return $this->respond($property);
    }
}

