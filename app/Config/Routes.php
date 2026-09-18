<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Pages::home');
$routes->get('/about', 'Pages::about');
$routes->get('/customers', 'Customers::index');
$routes->get('/users', 'Users::index');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->post('/logout', 'Auth::logout');
$routes->get('/products', 'Products::index', ['filter' => 'auth']);
$routes->get('/products/create', 'Products::create', ['filter' => 'auth']);
$routes->post('/products', 'Products::store', ['filter' => 'auth']);