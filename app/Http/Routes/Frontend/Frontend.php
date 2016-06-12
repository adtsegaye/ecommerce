<?php

/**
 * Frontend Controllers.
 */
$router->get('/', 'FrontendController@index')->name('home');
$router->get('/category', 'FrontendCategoryController@index')->name('frontend.category');

$router->get('product/trend', 'Product\FrontendProductController@trends')->name('frontend.product.trends');
$router->get('product', 'Product\FrontendProductController@index')->name('frontend.product');
$router->get('macros', 'FrontendController@macros');


$router->group(['prefix' => 'api/v1'], function () {
    Route::resource('product', 'Api\Product\ApiProductController');
});

/*
 * These frontend controllers require the user to be logged in
 */
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('dashboard', 'DashboardController@index')->name('frontend.dashboard');
    $router->get('profile/edit', 'ProfileController@edit')->name('frontend.profile.edit');
    $router->patch('profile/update', 'ProfileController@update')->name('frontend.profile.update');
});
