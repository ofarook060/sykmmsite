<?php
namespace App\Controllers;
use App\Models\PropertyModel;
// 1. Import the API Response trait
use CodeIgniter\API\ResponseTrait;

class Properties extends BaseController {
    // 2. Enable the trait inside your controller class
    use ResponseTrait;

    public function index() {
        $model = new PropertyModel();
        $properties = $model->findAll();

        // 3. Handle Content Negotiation
        // If request wants JSON (like React Native), send JSON. Otherwise, send web view.
        if ($this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json' || $this->request->getGet('format') === 'json') {
            return $this->respond($properties);
        }

        $data['properties'] = $properties;
        return view('properties/index', $data);
    }

    public function view($id) {
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

    public function create() {
        // Handle Mobile API Submissions (JSON data)
        $isJsonRequest = $this->request->negotiate('media', ['text/html', 'application/json']) === 'application/json';

        // Protect route via manual session check (Only for web browsers)
        if (!$isJsonRequest && !session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login');
        }

        if ($this->request->is('post')) {
            $model = new PropertyModel();
            $uploadedImages = [];

            // Image handling (Supported for traditional multi-part form submissions)
            if ($imageFiles = $this->request->getFiles()) {
                if (isset($imageFiles['property_images'])) {
                    foreach ($imageFiles['property_images'] as $img) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $targetPath = ROOTPATH . 'public/uploads/';
                            $img->move($targetPath, $newName);

                            // Image Optimization & Auto-Resize
                            \Config\Services::image()
                                ->withFile($targetPath . $newName)
                                ->resize(800, 600, true, 'height')
                                ->save($targetPath . $newName);

                            $uploadedImages[] = $newName;
                        }
                    }
                }
            }

            // Pull fields dynamically (Works for both JSON bodies and traditional $_POST forms)
            $propertyData = [
                'title'          => $this->request->getVar('title'),
                'location'       => $this->request->getVar('location'),
                'price'          => $this->request->getVar('price'),
                'size'           => $this->request->getVar('size'),
                'rooms'          => $this->request->getVar('rooms'),
                'masterBedrooms' => $this->request->getVar('masterBedrooms'),
                'bedrooms'       => $this->request->getVar('bedrooms'),
                'bathrooms'      => $this->request->getVar('bathrooms'),
                'description'    => $this->request->getVar('description'),
                'facebookPost'   => $this->request->getVar('facebookPost'),
                'images'         => !empty($uploadedImages) ? json_encode($uploadedImages) : null
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
