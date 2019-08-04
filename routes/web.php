<?php

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
// Baisc Route
$router->get('/', function () use ($router) {
    return $router->app->version();
});

// User Auth Route
$router->post('auth', 'UserController@auth');

// All Products Route
$router->get('products', 'ProductController@allProducts');

// Token Based User And Product Routes
$router->group(['middleware' => 'jwt.auth'], function() use ($router) {
	$router->get('user', 'UserController@detail');
	$router->get('user/products', 'ProductController@userProducts');
	$router->post('user/products', 'ProductController@createProduct');
	$router->delete('user/products/{sku}', 'ProductController@deleteProduct');	
});