<?php

namespace App\Controllers;

use App\Models\PropertyModel;
use CodeIgniter\API\ResponseTrait;

class Properties extends BaseController
{
    use ResponseTrait;

    private function extractIframeSrc(?string $input): ?string
    {
        if ($input === null || $input === '') {
            return $input;
        }
        if (preg_match('/<iframe[^>]+src\s*=\s*"([^"]+)"/i', $input, $m)) {
            return $m[1];
        }
        return $input;
    }

    private function normalizeAttachments($stored): array
    {
        if (empty($stored)) {
            return [];
        }

        $decoded = json_decode($stored, true);
        if (is_array($decoded)) {
            return array_map(function ($item) {
                if (is_string($item)) {
                    return [
                        'path' => $item,
                        'name' => basename($item),
                    ];
                }
                return [
                    'path' => $item['path'] ?? '',
                    'name' => $item['name'] ?? basename($item['path'] ?? ''),
                ];
            }, $decoded);
        }

        // Legacy string path support
        return [[
            'path' => $stored,
            'name' => basename($stored),
        ]];
    }

    private function moveUploadedFiles(array $fieldNames, string $targetDir, string $publicPrefix = '/uploads/'): array
    {
        $uploaded = [];
        $files = $this->request->getFiles();

        foreach ($fieldNames as $fieldName) {
            if (! isset($files[$fieldName])) {
                continue;
            }

            $field = $files[$fieldName];
            $items = is_array($field) ? $field : [$field];

            foreach ($items as $file) {
                if (! $file->isValid() || $file->hasMoved()) {
                    continue;
                }
                $newName = $file->getRandomName();
                $file->move($targetDir, $newName);
                $uploaded[] = [
                    'path' => $publicPrefix . $newName,
                    'name' => $file->getClientName(),
                ];
            }
        }

        return $uploaded;
    }

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
            $uploadedFiles = $this->moveUploadedFiles(['files', 'images', 'attachments'], ROOTPATH . 'public/uploads/', '/uploads/');
            $existingFiles = $this->normalizeAttachments($property['images']);

            $imagePath = $property['images'];
            if (! empty($uploadedFiles)) {
                $imagePath = json_encode(array_merge($existingFiles, $uploadedFiles));
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
                'facebookPost'   => $this->extractIframeSrc($this->request->getVar('facebookPost')),
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
            $uploadedFiles = $this->moveUploadedFiles(['files', 'images', 'attachments'], ROOTPATH . 'public/uploads/', '/uploads/');
            $imageJsonString = !empty($uploadedFiles) ? json_encode($uploadedFiles) : null;

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
                'facebookPost'   => $this->extractIframeSrc($this->request->getVar('facebookPost')),
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
