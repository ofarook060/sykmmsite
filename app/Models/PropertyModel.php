<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyModel extends Model
{
    protected $table = 'properties';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'images', 'location', 'size', 'price', 'rooms',
        'masterBedrooms', 'bedrooms', 'bathrooms', 'description', 'facebookPost',
    ];

    protected $validationRules = [
        'title'          => 'required|max_length[255]',
        'location'       => 'permit_empty|max_length[255]',
        'size'           => 'permit_empty|max_length[255]',
        'price'          => 'permit_empty|max_length[255]',
        'rooms'          => 'permit_empty|max_length[255]',
        'masterBedrooms' => 'permit_empty|max_length[255]',
        'bedrooms'       => 'permit_empty|max_length[255]',
        'bathrooms'      => 'permit_empty|max_length[255]',
        'facebookPost'   => 'permit_empty|valid_url_strict',
    ];

    protected $validationMessages = [
        'title' => [
            'required'   => 'Property title is required.',
            'max_length' => 'Property title cannot exceed 255 characters.',
        ],
        'location'       => ['max_length' => 'Location cannot exceed 255 characters.'],
        'size'           => ['max_length' => 'Size cannot exceed 255 characters.'],
        'price'          => ['max_length' => 'Price cannot exceed 255 characters.'],
        'rooms'          => ['max_length' => 'Rooms cannot exceed 255 characters.'],
        'masterBedrooms' => ['max_length' => 'Master bedrooms cannot exceed 255 characters.'],
        'bedrooms'       => ['max_length' => 'Bedrooms cannot exceed 255 characters.'],
        'bathrooms'      => ['max_length' => 'Bathrooms cannot exceed 255 characters.'],
        'facebookPost' => [
            'valid_url_strict' => 'Please provide a valid full web address link for the Facebook post.',
        ],
    ];
}
