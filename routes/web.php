<?php

/*
|--------------------------------------------------------------------------
| #WEB
|--------------------------------------------------------------------------
*/



use App\Controllers\Admin\PostsController;
use App\Controllers\Admin\UsersController;
use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\PasswordController;
use App\Controllers\HomeController;
use App\Middleware\AuthMiddleware;
use App\Middleware\OldInputMiddleware;



// #HOME
// =========================================================================

$app->get('/', HomeController::class . ':index')->setName("home");
$app->post('/', HomeController::class . ':post');




// #AUTH
// =========================================================================

$app->get('/login', AuthController::class . ':showLogin')->setName('login');
$app->post('/login', AuthController::class . ':postLogin');
$app->get('/logout', AuthController::class . ':getLogout')->setName('logout');
$app->get('/forgot', PasswordController::class . ':getForgot')->setName('forgot');
$app->post('/forgot', PasswordController::class . ':postForgot');
$app->get('/reset/{token}', PasswordController::class . ':getReset')->setName('reset');
$app->post('/reset/{token}', PasswordController::class . ':postReset');




// #POSTS
// =========================================================================

$app->group('/admin', function() {
    $this->get('', PostsController::class . ':index')->setName('posts.index');
    $this->get('/posts/create', PostsController::class . ':create')->setName('posts.create');
    $this->post('/posts/create', PostsController::class . ':store');
    $this->get('/posts/edit/{id}', PostsController::class . ':edit')->setName('posts.edit');
    $this->post('/posts/edit/{id}', PostsController::class . ':update');
    $this->get('/posts/delete/{id}', PostsController::class . ':delete')->setName('posts.delete');
    $this->post('/posts/delete/{id}', PostsController::class . ':trash');
    $this->get('/posts/{slug}', PostsController::class . ':show')->setName('posts.view');
})->add(AuthMiddleware::class);




// #USERS
// =========================================================================

$app->group('/admin/user', function() {
    $this->get('/{id}', UsersController::class . ':view')->setName('users.view');
    $this->get('/edit/{id}', UsersController::class . ':edit')->setName('users.edit');
    $this->post('/edit/{id}', UsersController::class . ':update');
})->add(AuthMiddleware::class);




// #VIEW POSTS
// =========================================================================

$app->get('/{slug}', HomeController::class . ':viewPost')->setName("home.post");