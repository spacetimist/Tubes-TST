<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', function () {
    return view('dashboard');
});

$routes->group('auth', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->post('register', 'AuthController::register');

    // View aja
    $routes->get('register', function () {
        echo view('register');
    });
    $routes->get('login', function () {
        echo view('login');
    });
});

$routes->group('assessment', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->match(['get', 'post'], '/', 'AssessmentController::index');
    $routes->put('update', 'AssessmentController::updateResult');


    // view aja
    // result?user_id={user_id}
    $routes->get('result', 'AssessmentController::result');
    $routes->get('questions', 'AssessmentController::questions');


});


