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
