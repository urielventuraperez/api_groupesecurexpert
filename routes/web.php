<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Unauth routes
$router->post('/login','UserController@login');

//Auth routes middleware
$router->group(['prefix' => 'api', 'middleware' => ['auth', 'client']], function () use ($router) {
    // Users
    $router->post('/register','UserController@register');
    $router->post('/logout','UserController@logout');
    $router->post('/update/password','UserController@updatePassword');
    $router->get('users','UserController@getUsers');
    $router->get('/me','UserController@profile');

    // Faqs
    $router->get('/faq', 'FaqController@index');
    $router->get('faq/{id}', 'FaqController@show');
    $router->post('/faq','FaqController@create');

    // Visitors
    $router->get('/visitors', 'VisitorController@index');
    $router->post('/visitors','VisitorController@create');

    // Companies
    // Mostrar todos
    $router->post('/company', 'CompanyController@create');
    $router->get('/company/{id}', 'CompanyController@show');
    $router->delete('/company/{id}', 'CompanyController@delete');
    $router->post('company/{id}', 'CompanyController@active');
    $router->post('company/{id}/detail', 'CompanyController@addDetail');

    //Details
});
