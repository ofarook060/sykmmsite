<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
/**
$routes->get('/', 'Home::index');
**/
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

$routes->get('properties', 'Properties::index');
$routes->get('property/(:num)', 'Properties::view/$1');
$routes->get('properties/create', 'Properties::create');
$routes->post('properties/create', 'Properties::create');

$routes->get('posts', 'Posts::index');
$routes->get('post/(:num)', 'Posts::view/$1');
$routes->get('posts/create', 'Posts::create');
$routes->post('posts/create', 'Posts::create');

$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('/', 'Home::index');

// Dedicated group for your React Native Mobile App
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Maps GET /api/properties to index()
    $routes->get('properties', 'Properties::index');
    
    // Maps GET /api/properties/1 to show(1)
    $routes->get('properties/(:num)', 'Properties::show/$1');
});

// Dedicated namespace group for your React Native Mobile App
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Properties routes
    $routes->get('properties', 'Properties::index');
    $routes->get('properties/(:num)', 'Properties::show/$1');
    
    // Posts endpoints
    $routes->get('posts', 'Posts::index');
    $routes->get('posts/(:num)', 'Posts::show/$1');
    
    // Admin API endpoints
    $routes->post('admin/login', 'AdminAuth::login');
    $routes->get('admin/dashboard', 'AdminDashboard::index');
});
