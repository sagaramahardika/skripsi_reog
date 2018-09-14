<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Login Routes
Route::get('/', [ 
    'uses'  => 'LoginController@index',
    'as'    => 'login-form',
]);

Route::post('/', [ 
    'uses'  => 'LoginController@login',
    'as'    => 'login',
]);

// Register Routes
Route::get('/register', [ 
    'uses'  => 'RegisterController@index',
    'as'    => 'register-form',
]);

Route::post('/register', [ 
    'uses'  => 'RegisterController@register',
    'as'    => 'register',
]);

Route::get('/logout', [
    'uses'  => 'LoginController@logout',
    'as'    => 'logout',
]);

Route::group( ['prefix' => 'admin'], function() {
    Route::get('/', [ 
        'uses'  => 'AdminController@index',
        'as'    => 'admin.dashboard',
    ]);

    Route::group( ['prefix' => 'fakultas'], function() {
        Route::get('/', [
            'uses'  => 'FakultasController@index',
            'as'    => 'fakultas.index',
        ]);
        Route::get('/add', [
            'uses'  => 'FakultasController@create',
            'as'    => 'fakultas.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'FakultasController@edit',
            'as'    => 'fakultas.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'FakultasController@all',
            'as'    => 'fakultas.all',
        ]);
        Route::post('/store', [
            'uses'  => 'FakultasController@store',
            'as'    => 'fakultas.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'FakultasController@update',
            'as'    => 'fakultas.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'FakultasController@delete',
            'as'    => 'fakultas.delete',
        ]);
    });

    Route::group( ['prefix' => 'prodi'], function() {
        Route::get('/', [
            'uses'  => 'ProdiController@index',
            'as'    => 'prodi.index',
        ]);
        Route::get('/add', [
            'uses'  => 'ProdiController@create',
            'as'    => 'prodi.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'ProdiController@edit',
            'as'    => 'prodi.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'ProdiController@all',
            'as'    => 'prodi.all',
        ]);
        Route::post('/store', [
            'uses'  => 'ProdiController@store',
            'as'    => 'prodi.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'ProdiController@update',
            'as'    => 'prodi.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'ProdiController@delete',
            'as'    => 'prodi.delete',
        ]);
    });

});

Route::group( ['prefix' => 'dosen'], function() {
    Route::get('/', [ 
        'uses'  => 'DosenController@index',
        'as'    => 'dosen.dashboard',
    ]);
});

Route::group( ['prefix' => 'kaprodi'], function() {
    Route::get('/', [ 
        'uses'  => 'KaprodiController@index',
        'as'    => 'kaprodi.dashboard',
    ]);
});