<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function() {
	return redirect('/web');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::bind('service', function() {

});

Route::group(['prefix' => 'web'], function() {
	Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
		Route::get('/', ['as' => 'admin', 'uses' => 'Admin\IndexController@getIndex']);
		Route::get('/services', ['as' => 'services.index', 'uses' => 'Admin\ServicesController@getIndex']);
		Route::get('/services/create', ['as' => 'services.create', 'uses' => 'Admin\ServicesController@getCreate']);
		Route::post('/services/store', ['as' => 'services.store', 'uses' => 'Admin\ServicesController@postStore']);
		Route::get('/services/edit/{service}', ['as' => 'services.edit', 'uses' => 'Admin\ServicesController@getEdit']);
		Route::post('/services/update/{service}', ['as' => 'services.update', 'uses' => 'Admin\ServicesController@postUpdate']);
		Route::get('/services/delete/{service}', ['as' => 'services.delete', 'uses' => 'Admin\ServicesController@getDelete']);
		Route::post('/services/destroy/{service}', ['as' => 'services.destroy', 'uses' => 'Admin\ServicesController@postDestroy']);

		Route::get('/blocks', ['as' => 'blocks.index', 'uses' => 'Admin\BlockController@getIndex']);
		Route::get('/blocks/create', ['as' => 'blocks.create', 'uses' => 'Admin\BlockController@getCreate']);
		Route::post('/blocks/store', ['as' => 'blocks.store', 'uses' => 'Admin\BlockController@postStore']);
		Route::get('/blocks/edit/{block}', ['as' => 'blocks.edit', 'uses' => 'Admin\BlockController@getEdit']);
		Route::post('/blocks/update/{block}', ['as' => 'blocks.update', 'uses' => 'Admin\BlockController@postUpdate']);

		Route::get('/users', ['as' => 'users.index', 'uses' => 'Admin\UsersController@getIndex']);
		Route::get('/users/create', ['as' => 'users.create', 'uses' => 'Admin\UsersController@getCreate']);
		Route::post('/users/store', ['as' => 'users.store', 'uses' => 'Admin\UsersController@postStore']);
		Route::get('/users/edit/{user}', ['as' => 'users.edit', 'uses' => 'Admin\UsersController@getEdit']);
		Route::post('/users/update/{user}', ['as' => 'users.update', 'uses' => 'Admin\UsersController@postUpdate']);
	});

	Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
	Route::get('/services/{service}', ['as' => 'services.view', 'uses' => 'ServicesController@getIndex']);
});

Route::group(array('prefix' => 'api/v1', 'before' => 'auth.basic'), function() {
	Route::resource('finance/bcentral', 'API\V1\Finance\BcentralController', ['only' => ['index']]);
});
