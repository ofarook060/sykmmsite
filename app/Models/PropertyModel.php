<?php
namespace App\Models;
use CodeIgniter\Model;

class PropertyModel extends Model {
    protected $table = 'properties';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'images', 'location', 'size', 'price', 'rooms', 
        'masterBedrooms', 'bedrooms', 'bathrooms', 'description', 'facebookPost'
    ];
}

