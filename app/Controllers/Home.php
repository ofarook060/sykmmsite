<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\PropertyModel;

class Home extends BaseController
{
    public function index()
    {
        $propertyModel = new PropertyModel();
        $postModel = new PostModel();

        // Get filter inputs from the search form
        $location = $this->request->getGet('location');
        $maxPrice = $this->request->getGet('price');

        // Base property query
        $propertiesQuery = $propertyModel;

        if (!empty($location)) {
            $propertiesQuery = $propertiesQuery->like('location', $location);
        }
        if (!empty($maxPrice)) {
            $propertiesQuery = $propertiesQuery->where('price <=', $maxPrice);
        }

        $data = [
            // Get up to 6 properties based on filters
            'properties'   => $propertiesQuery->orderBy('id', 'DESC')->findAll(6),
            // Get the 3 latest blog posts
            'latest_posts' => $postModel->orderBy('id', 'DESC')->findAll(3),
            // Pass search parameters back to keep inputs filled
            'old_location' => $location,
            'old_price'    => $maxPrice,
        ];

        return view('home', $data);
    }
}
