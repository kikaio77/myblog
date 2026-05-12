<?php

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->addRedirect('/', 'main');

$routes->get('test', static function(){
    $db = \Config\Database::connect();

$builder = $db->table('posts');
$subQry = $db->table('posts')->selectMax('id', 'recently_post_id');
$builder->where('id = ', $subQry);

echo $builder->getCompiledSelect();
});
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
    $routes->get('(:segment)/post', 'Category::list/$1', ['as' => 'category.post']);
});
$routes->get('/main', 'Home::index');
$routes->get('/profile', 'Home::profile');
$routes->get('/portfolio', 'Home::portfolio');

$routes->group('login', static function($routes) {
    $routes->get('form', 'Login');
    $routes->post('in', 'Login::in');
    $routes->get('out', 'Login::out');

});

$routes->group('join', static function($routes) {
    $routes->get('/', 'Join');
    $routes->post('submit', 'Join::submit');
});

$routes->group('comment', static function($routes) {
    $routes->get('list/(:num)', 'Comment::list/$1');
    $routes->post('new', 'Comment::new');
    $routes->post('drop', 'Comment::drop');
    $routes->post('modify', 'Comment::modify');
});

$routes->group('oauth', static function($routes) {
    $routes->get('social/(:alpha)', 'OAuth::social/$1');
});