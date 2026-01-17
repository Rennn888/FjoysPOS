<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// POS Application
$routes->get('pos', 'Pos::index');
$routes->get('pos/reset-counter', 'Pos::resetOrderCounter');
$routes->post('pos/reset-counter', 'Pos::resetOrderCounter');

// Dashboard Routes
$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashboard/products', 'Dashboard::products');
$routes->get('dashboard/reports', 'Dashboard::reports');

// API Routes
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Products
    $routes->get('products', 'ProductController::index');
    $routes->get('products/(:num)', 'ProductController::show/$1');
    
    // Transactions
    $routes->post('transactions/sync', 'TransactionController::sync');
    $routes->get('transactions/daily-sales', 'TransactionController::dailySales');
    $routes->get('transactions/report', 'TransactionController::report');
});
