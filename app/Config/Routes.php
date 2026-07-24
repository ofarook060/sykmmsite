<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Core Session Authentication Routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// Public Web Views for Property Directories
$routes->get('properties', 'Properties::index');
$routes->get('properties/view/(:num)', 'Properties::view/$1'); // Synchronized with view file links

// Admin Backend Property Data Pipelines
$routes->get('properties/create', 'Properties::create');
$routes->post('properties/store', 'Properties::create');       // Links view forms securely to store logic
$routes->get('properties/edit/(:num)', 'Properties::edit/$1');
$routes->post('properties/edit/(:num)', 'Properties::edit/$1'); // Processes edits via post back
$routes->post('properties/delete/(:num)', 'Properties::delete/$1');

// Public Web Views for Blog Operations
$routes->get('posts', 'Posts::index');
$routes->get('post/(:num)', 'Posts::view/$1');

// Admin Backend Blog Operations
$routes->get('posts/create', 'Posts::create');
$routes->post('posts/create', 'Posts::create');
$routes->get('posts/edit/(:num)', 'Posts::edit/$1');
$routes->post('posts/edit/(:num)', 'Posts::edit/$1');
$routes->post('posts/delete/(:num)', 'Posts::delete/$1');

// Base Site Views
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('/', 'Home::index');

// RESTful JSON API Router Engine (Namespace prefixed automatically)
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    
    // Auth route inside Api group
    $routes->post('adminauth/login', 'AdminAuth::login');

    // Public API endpoints (No token checks required)
    $routes->get('properties', 'Properties::index');
    $routes->get('properties/(:num)', 'Properties::show/$1');
    $routes->get('posts', 'Posts::index');
    $routes->get('posts/(:num)', 'Posts::show/$1');

    // Protected API endpoints (Filtered via your custom 'apiauth' middle layer)
    $routes->group('', ['filter' => 'apiauth'], function ($routes) {
        $routes->post('properties', 'Properties::create');
        $routes->put('properties/(:num)', 'Properties::update/$1');
        $routes->delete('properties/(:num)', 'Properties::delete/$1');
        
        $routes->post('posts', 'Posts::create');
        $routes->put('posts/(:num)', 'Posts::update/$1');
        $routes->delete('posts/(:num)', 'Posts::delete/$1');
        
        $routes->get('admin-dashboard', 'AdminDashboard::index');
    });
});
