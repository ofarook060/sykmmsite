<?php

namespace App\Controllers;

use App\Models\PropertyModel;
use CodeIgniter\API\ResponseTrait;

class Properties extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new PropertyModel();
        $properties = $model->findAll();

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
            if ($this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json' || $this->request->getGet('format') === 'json') {
                return $this->failNotFound('Property not found');
            }
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

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
            $uploadedImages = [];
            
            // Check for multiple files from web form (images[])
            if ($files = $this->request->getFiles()) {
                if (isset($files['images']) && is_array($files['images'])) {
                    foreach ($files['images'] as $img) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $img->move(ROOTPATH . 'public/uploads/', $newName);
                            $uploadedImages[] = '/uploads/' . $newName;
                        }
                    }
                }
            }

            // Fallback check for single file from mobile API (images)
            $singleFile = $this->request->getFile('images');
            if ($singleFile && $singleFile->isValid() && !$singleFile->hasMoved()) {
                $newName = $singleFile->getRandomName();
                $singleFile->move(ROOTPATH . 'public/uploads/', $newName);
                $uploadedImages[] = '/uploads/' . $newName;
            }

            // Merge with existing images if new ones were uploaded, otherwise keep old ones
            if (!empty($uploadedImages)) {
                $existing = !empty($property['images']) ? json_decode($property['images'], true) : [];
                $imagePath = json_encode(array_merge(is_array($existing) ? $existing : [], $uploadedImages));
            } else {
                $imagePath = $property['images'];
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

            // If validation failed, redirect back with inputs and error logs
            return redirect()->back()->withInput()->with('errors', $model->errors());
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
        $isJsonRequest = $this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json';

        if (!$isJsonRequest && !session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login');
        }

        // Changed form submission targeting from index logic to explicit save/store check
        if ($this->request->is('post')) {
            $model = new PropertyModel();
            $uploadedImages = [];

            // 1. Process multiple file uploads array from web form (images[])
            if ($files = $this->request->getFiles()) {
                if (isset($files['images']) && is_array($files['images'])) {
                    foreach ($files['images'] as $img) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $img->move(ROOTPATH . 'public/uploads/', $newName);
                            $uploadedImages[] = '/uploads/' . $newName;
                        }
                    }
                }
            }

            // 2. Process single file fallback from mobile applications (images)
            $singleFile = $this->request->getFile('images');
            if ($singleFile && $singleFile->isValid() && !$singleFile->hasMoved()) {
                $newName = $singleFile->getRandomName();
                $singleFile->move(ROOTPATH . 'public/uploads/', $newName);
                $uploadedImages[] = '/uploads/' . $newName;
            }

            $imageJsonString = !empty($uploadedImages) ? json_encode($uploadedImages) : null;

            $propertyData = [
                'title'          => $this->request->getVar('title'),
                'images'         => $imageJsonString,
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
                return redirect()->to('/properties')->with('success', 'Property created successfully!');
            }

            // 3. Explicit Model Validation Error Catcher
            if ($isJsonRequest) {
                return $this->fail($model->errors());
            }

            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return view('properties/create');
    }
}
