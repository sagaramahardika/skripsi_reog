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

    Route::group( ['prefix' => 'dosen'], function() {
        Route::get('/', [
            'uses'  => 'AdminDosenController@index',
            'as'    => 'admin_dosen.index',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'AdminDosenController@edit',
            'as'    => 'admin_dosen.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'AdminDosenController@all',
            'as'    => 'admin_dosen.all',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'AdminDosenController@update',
            'as'    => 'admin_dosen.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'AdminDosenController@delete',
            'as'    => 'admin_dosen.delete',
        ]);
    });

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

    Route::group( ['prefix' => 'periode'], function() {
        Route::get('/', [
            'uses'  => 'PeriodeController@index',
            'as'    => 'periode.index',
        ]);
        Route::get('/add', [
            'uses'  => 'PeriodeController@create',
            'as'    => 'periode.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'PeriodeController@edit',
            'as'    => 'periode.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'PeriodeController@all',
            'as'    => 'periode.all',
        ]);
        Route::post('/store', [
            'uses'  => 'PeriodeController@store',
            'as'    => 'periode.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'PeriodeController@update',
            'as'    => 'periode.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'PeriodeController@delete',
            'as'    => 'periode.delete',
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

    Route::group( ['prefix' => 'mahasiswa'], function() {
        Route::get('/', [
            'uses'  => 'MahasiswaController@index',
            'as'    => 'mahasiswa.index',
        ]);
        Route::get('/add', [
            'uses'  => 'MahasiswaController@create',
            'as'    => 'mahasiswa.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'MahasiswaController@edit',
            'as'    => 'mahasiswa.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'MahasiswaController@all',
            'as'    => 'mahasiswa.all',
        ]);
        Route::post('/store', [
            'uses'  => 'MahasiswaController@store',
            'as'    => 'mahasiswa.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'MahasiswaController@update',
            'as'    => 'mahasiswa.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'MahasiswaController@delete',
            'as'    => 'mahasiswa.delete',
        ]);
    });

    Route::group( ['prefix' => 'matkul'], function() {
        Route::get('/', [
            'uses'  => 'MataKuliahController@index',
            'as'    => 'matkul.index',
        ]);
        Route::get('/add', [
            'uses'  => 'MataKuliahController@create',
            'as'    => 'matkul.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'MataKuliahController@edit',
            'as'    => 'matkul.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'MataKuliahController@all',
            'as'    => 'matkul.all',
        ]);
        Route::post('/store', [
            'uses'  => 'MataKuliahController@store',
            'as'    => 'matkul.store',
        ]);
        Route::post('/import', [
            'uses'  => 'MataKuliahController@import',
            'as'    => 'matkul.import',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'MataKuliahController@update',
            'as'    => 'matkul.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'MataKuliahController@delete',
            'as'    => 'matkul.delete',
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