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
        'title'    => 'required|max_length[255]',
        'location' => 'permit_empty|max_length[255]',
        'price'    => 'permit_empty|integer',
        'rooms'    => 'permit_empty|integer',
        'bedrooms' => 'permit_empty|integer',
        'bathrooms' => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Property title is required.',
        ],
        'price' => [
            'integer' => 'Price must be a whole number.',
        ],
    ];
}
