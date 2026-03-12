<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->addRedirect('/', 'main');

$routes->group('posts', static function($routes) {
    $routes->get('(:num)?', 'PostController::list/$1');
    $routes->get('form', 'PostController::form');
    $routes->get('(:num)?/form', 'PostController::form/$1');
    $routes->put('(:num)', 'PostController::update/$1');

});
$routes->get('/main', 'Home::index');
$routes->get('/profile', 'Home::profile');
$routes->get('/portfolio', 'Home::portfolio');