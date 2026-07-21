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
$routes->get('properties/edit/(:num)', 'Properties::edit/$1');
$routes->post('properties/edit/(:num)', 'Properties::edit/$1');
$routes->post('properties/delete/(:num)', 'Properties::delete/$1');

$routes->get('posts', 'Posts::index');
$routes->get('post/(:num)', 'Posts::view/$1');
$routes->get('posts/create', 'Posts::create');
$routes->post('posts/create', 'Posts::create');
$routes->get('posts/edit/(:num)', 'Posts::edit/$1');
$routes->post('posts/edit/(:num)', 'Posts::edit/$1');
$routes->post('posts/delete/(:num)', 'Posts::delete/$1');

$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('/', 'Home::index');

// API routes using App\Controllers\Api namespace to ensure JSON response handling.
$routes->group('api', function ($routes) {
    $routes->post('adminauth/login', 'Api\AdminAuth::login');

    // Public read-only routes (no auth required)
    $routes->get('properties', 'Api\Properties::index');
    $routes->get('properties/(:num)', 'Api\Properties::show/$1');
    $routes->get('posts', 'Api\Posts::index');
    $routes->get('posts/(:num)', 'Api\Posts::show/$1');

    // Protected routes (auth required)
    $routes->group('', ['filter' => 'apiauth'], function ($routes) {
        $routes->post('properties', 'Api\Properties::create');
        $routes->put('properties/(:num)', 'Api\Properties::update/$1');
        $routes->delete('properties/(:num)', 'Api\Properties::delete/$1');
        $routes->post('posts', 'Api\Posts::create');
        $routes->put('posts/(:num)', 'Api\Posts::update/$1');
        $routes->delete('posts/(:num)', 'Api\Posts::delete/$1');
        $routes->get('admin-dashboard', 'Api\AdminDashboard::index');
    });
});
