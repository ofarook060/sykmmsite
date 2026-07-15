<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PropertyModel;
use App\Models\PostModel;

class AdminController extends 
ResourceController
{
    protected $format = 'json';

    // GET /api/admin/dashboard
    public function dashboard()
    {
        // Note: Standard session checks do 
not work reliably with stateless REST APIs.
        // It is highly recommended to 
secure this endpoint using JWT or API Keys.
        if 
(!session()->get('isAdminLoggedIn')) {
            return 
$this->failUnauthorized('Access denied. 
Please log in.');
        }

        $propertyModel = new 
PropertyModel();
        $postModel = new PostModel();

        $data = [
            'total_properties'  => 
$propertyModel->countAllResults(),
            'total_posts'       => 
$postModel->countAllResults(),
            'recent_properties' => 
$propertyModel->orderBy('id', 
'DESC')->findAll(5),
            'recent_posts'      => 
$postModel->orderBy('id', 
'DESC')->findAll(5)
        ];

        return $this->respond($data, 200);
    }
}
