<?php
namespace App\Controllers;
use App\Models\PropertyModel;
use App\Models\PostModel;

class Admin extends BaseController {
    
    public function dashboard() {
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Access denied.');
        }

        $propertyModel = new PropertyModel();
        $postModel = new PostModel();

        $data = [
            'total_properties' => $propertyModel->countAllResults(),
            'total_posts'      => $postModel->countAllResults(),
            'recent_properties'=> $propertyModel->orderBy('id', 'DESC')->findAll(5),
            'recent_posts'     => $postModel->orderBy('id', 'DESC')->findAll(5)
        ];

        return view('admin/dashboard', $data);
    }
}

