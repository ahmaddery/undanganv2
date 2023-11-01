<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/index', 'Home::index');
$routes->get('template', 'Home::template');
$routes->get('admin/dashboard', 'Home::admin');


// app/Config/Routes.php

$routes->get('login', 'Auth::login'); // Rute untuk halaman login
$routes->get('auth/login', 'Auth::login'); // Rute untuk halaman login
$routes->post('auth/login', 'Auth::login'); // Rute untuk proses login (POST request)

$routes->get('register', 'Auth::register'); // Rute untuk halaman register
$routes->post('auth/register', 'Auth::register'); // Rute untuk proses registrasi (POST request)
$routes->get('auth/logout', 'Auth::logout');

$routes->get('forgot_password', 'Auth::forgotPassword');
$routes->post('auth/forgotPassword', 'Auth::forgotPassword');
$routes->get('reset_password/(:segment)', 'Auth::resetPassword/$1');
$routes->post('auth/processResetPassword', 'Auth::processResetPassword');

$routes->get('/user', 'ProfileController::index');
$routes->get('/user/show', 'ProfileController::index');
$routes->get('/user/edit', 'ProfileController::edit');
$routes->post('/profile/update', 'ProfileController::update');
$routes->get('/admin/profile', 'Profilecontroller::user');

$routes->get('dashboard', 'Dashboard::index');


