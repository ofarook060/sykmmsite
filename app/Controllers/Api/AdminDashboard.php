<?php

namespace App\Controllers\Api;

use App\Models\PropertyModel;
use App\Models\PostModel;

class AdminDashboard extends BaseApiController
{
    public function index()
    {
        log_message('debug', 'AdminDashboard::index reached');
        $propertyModel = new PropertyModel();
        $postModel = new PostModel();

        return $this->respond([
            'status' => 'success',
            'data' => [
                'total_properties' => $propertyModel->countAllResults(),
                'total_posts' => $postModel->countAllResults(),
                'recent_posts' => $postModel->orderBy('id', 'DESC')->findAll(5),
            ]
        ]);
    }
}
