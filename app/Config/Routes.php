<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
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

// API routes using App\Controllers\Api namespace to ensure JSON response handling.
$routes->group('api', function($routes) {
    $routes->resource('properties', ['controller' => 'Api\Properties']);
    $routes->resource('posts', ['controller' => 'Api\Posts']);
    $routes->get('admin-dashboard', 'Api\AdminDashboard::index');
});
