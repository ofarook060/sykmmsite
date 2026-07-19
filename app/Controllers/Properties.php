<?php

namespace App\Controllers;

use App\Models\PropertyModel;
// 1. Import the API Response trait
use CodeIgniter\API\ResponseTrait;

class Properties extends BaseController
{
    // 2. Enable the trait inside your controller class
    use ResponseTrait;

    public function index()
    {
        $model = new PropertyModel();
        $properties = $model->findAll();

        // Enforce JSON for API routes
        if (strpos($this->request->getPath(), 'api/') === 0 || $this->request->getGet('format') === 'json') {
            return $this->respond($properties);
        }

        $data['properties'] = $properties;
        return view('properties/index', $data);
    }

    public function view($id)
    {
        $model = new PropertyModel();
        $property = $model->find($id);

        if (!$property) {
            // 4. Send API 404 for mobile apps, or standard PageNotFound for browsers
            if ($this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json' || $this->request->getGet('format') === 'json') {
                return $this->failNotFound('Property not found');
            }
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Parse images from JSON string to array if returning via API
        if ($this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json' || $this->request->getGet('format') === 'json') {
            if (!empty($property['images'])) {
                $property['images'] = json_decode($property['images']);
            }
            return $this->respond($property);
        }

        $data['property'] = $property;
        return view('properties/view', $data);
    }

    // Admin: Edit a property
    public function edit($id = null)
    {
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login');
        }

        $model = new PropertyModel();
        $property = $model->find($id);
        if (!$property) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('post')) {
            $imagePath = $property['images']; // Keep existing
            $file = $this->request->getFile('images');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $targetPath = ROOTPATH . 'public/uploads/';
                $file->move($targetPath, $newName);
                $imagePath = json_encode(['/uploads/' . $newName]);
            }

            $propertyData = [
                'id'             => $id,
                'title'          => $this->request->getVar('title'),
                'images'         => $imagePath,
                'location'       => $this->request->getVar('location'),
                'size'           => $this->request->getVar('size'),
                'price'          => $this->request->getVar('price'),
                'rooms'          => $this->request->getVar('rooms'),
                'masterBedrooms' => $this->request->getVar('masterBedrooms'),
                'bedrooms'       => $this->request->getVar('bedrooms'),
                'bathrooms'      => $this->request->getVar('bathrooms'),
                'description'    => $this->request->getVar('description'),
                'facebookPost'   => $this->request->getVar('facebookPost'),
            ];

            if ($model->save($propertyData)) {
                return redirect()->to('/admin/dashboard')->with('success', 'Property updated successfully!');
            }
        }

        return view('properties/edit', ['property' => $property]);
    }

    // Admin: Delete a property
    public function delete($id = null)
    {
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login');
        }

        $model = new PropertyModel();
        $model->delete($id);
        return redirect()->to('/admin/dashboard')->with('success', 'Property deleted!');
    }

    public function create()
    {

        // Handle Mobile API Submissions (JSON data or multipart)
        $isJsonRequest = $this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json';

        // Protect route via manual session check (Only for web browsers)
        if (!$isJsonRequest && !session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login');
        }

        if ($this->request->is('post')) {
            $model = new PropertyModel();

            // New Image handling logic for mobile multipart/form-data
            $imagePath = null;
            $file = $this->request->getFile('images'); // Matches key in Mobile App's FormData

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $targetPath = ROOTPATH . 'public/uploads/';
                $file->move($targetPath, $newName);

                // Store path in DB. Existing code expects JSON array.
                $imagePath = json_encode(['/uploads/' . $newName]);
            }

            // Pull fields dynamically
            $propertyData = [
                'title'          => $this->request->getVar('title'),
                'images'         => $imagePath,
                'location'       => $this->request->getVar('location'),
                'size'           => $this->request->getVar('size'),
                'price'          => $this->request->getVar('price'),
                'rooms'          => $this->request->getVar('rooms'),
                'masterBedrooms' => $this->request->getVar('masterBedrooms'),
                'bedrooms'       => $this->request->getVar('bedrooms'),
                'bathrooms'      => $this->request->getVar('bathrooms'),
                'description'    => $this->request->getVar('description'),
                'facebookPost'   => $this->request->getVar('facebookPost'),
            ];

            if ($model->save($propertyData)) {
                if ($isJsonRequest) {
                    return $this->respondCreated(['status' => true, 'message' => 'Property created successfully']);
                }
                return redirect()->to('/properties');
            }

            if ($isJsonRequest) {
                return $this->fail('Failed to save property records');
            }
        }

        return view('properties/create');
    }
}
