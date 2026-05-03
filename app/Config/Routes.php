<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/submit', 'Payment::submit');
$routes->post('/payment-callback', 'Payment::handleCallback');
$routes->get('/payment-success', 'Payment::success');
$routes->get('/payment-failed', 'Payment::failed');

// Admin Routes
$routes->get('/admin/dashboard', 'Admin::dashboard');
$routes->post('/admin/approve/(:num)', 'Admin::approveRequest/$1');
$routes->post('/admin/reject/(:num)', 'Admin::rejectRequest/$1');
$routes->get('/admin/view/(:num)', 'Admin::viewRequest/$1');
$routes->get('/admin/export-csv', 'Admin::exportCsv');
