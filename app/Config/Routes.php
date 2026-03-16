<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->addRedirect('/', 'main');

$routes->group('posts', static function($routes) {
    $routes->get('(:num)?', 'PostController::list/$1', ['as' => 'posts.list']);
    $routes->get('form', 'PostController::form');
    $routes->get('(:num)?/form', 'PostController::form/$1');
    $routes->post('', 'PostController::new');
    $routes->put('(:num)', 'PostController::update/$1');
});

$routes->group('upload', static function($routes) {
    $routes->post('image', 'Upload::image');
});

$routes->group('category', static function($routes) {
    $routes->get('(:segment)/post', 'Category::list/$1');
});
$routes->get('/main', 'Home::index');
$routes->get('/profile', 'Home::profile');
$routes->get('/portfolio', 'Home::portfolio');