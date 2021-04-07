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
$router->post('/super-admin/register','UserController@superadmin_register');

//Auth routes middleware
$router->group(['prefix' => 'api', 'middleware' => ['auth', 'client']], function () use ($router) {
    // Users
    $router->post('/register','UserController@register');
    $router->post('/logout','UserController@logout');
    $router->post('/update/password','UserController@updatePassword');
    $router->post('/update/info','UserController@updateProfile');
    $router->delete('/user/{id}','UserController@deleteUser');
    $router->post('/user/{id}','UserController@activeUser');
    $router->get('/users','UserController@getUsers');
    $router->get('/me','UserController@profile');

    // Roles
    $router->get('/roles','RoleController@index');

    // Insurances
    $router->get('/insurances', 'InsuranceController@index');

    // Faqs
    $router->get('/faq', 'FaqController@index');
    $router->get('faq/{id}', 'FaqController@show');
    $router->post('/faq','FaqController@create');
    $router->post('/faq/{id}','FaqController@update');
    $router->delete('/faq/{id}','FaqController@delete');


    // Visitors
    $router->get('/visitors', 'VisitorController@index');
    $router->post('/visitors','VisitorController@create');

    // Companies
    // Mostrar todos
    $router->get('/company', 'CompanyController@index');
    $router->post('/company', 'CompanyController@create');
    $router->get('/company/{id}', 'CompanyController@show');
    $router->delete('/company/{id}', 'CompanyController@delete');
    $router->post('company/{id}', 'CompanyController@active');
    $router->post('company/update/{id}', 'CompanyController@update');
    $router->post('company/{id}/detail', 'CompanyController@relationDetail');
    $router->post('company/{id_company}/detail/{id_detail}', 'CompanyController@updateRelationDetail');
    $router->post('company/{id_company}/detail/{id_detail}', 'CompanyController@deleteRelationDetail');

    // Deductible
    $router->post('company/{id_company}/deductible', 'DeductibleController@create');
    $router->delete('company/{id_company}/deductible/{id_deductible}', 'DeductibleController@delete');

    // Rates
    $router->get('rate/{id}','RateController@show'); // Show rates
    $router->post('company/{id_company}/rate', 'RateController@create');
    $router->post('company/{id_company}/rate/{id_rate}', 'RateController@update');
    $router->delete('company/{id_company}/rate/{id_rate}', 'RateController@delete');

    // Range sums to Rates
    $router->post('rate/{id}/year','RateController@addRangeYear');
    $router->post('rate/{id_rate}/year/{id_year}','RateController@updateRangeYear');
    $router->delete('rate/{id_rate}/year/{id_year}','RateController@deleteRangeYear');

    // Range sums to Rates
    $router->post('year/{id}/sum','RangeYearController@addSum');
    $router->post('year/{id_range}/sum/{id_sum}','RangeYearController@updateSum');
    $router->delete('year/{id_range}/sum/{id_sum}','RangeYearController@deleteSum');   

});
