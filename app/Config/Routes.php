<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', static function($routes) {
    return redirect('main');
});

$routes->group('posts', static function($routes) {
    $routes->get('(:num)', 'PostController::list/$1');
});
$routes->get('/main', 'Home::index');
$routes->get('/profile', 'Home::profile');
$routes->get('/portfolio', 'Home::portfolio');