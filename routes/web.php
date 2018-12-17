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
route::get('/coba',[
    'uses'  => 'cobasaja@mencoba',
    'as'    => 'coba',
]);

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

    Route::group( ['prefix' => 'acara'], function() {
        Route::get('/', [
            'uses'  => 'AcaraController@index',
            'as'    => 'acara.index',
        ]);
        Route::get('/add', [
            'uses'  => 'AcaraController@create',
            'as'    => 'acara.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'AcaraController@edit',
            'as'    => 'acara.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'AcaraController@all',
            'as'    => 'acara.all',
        ]);
        Route::post('/store', [
            'uses'  => 'AcaraController@store',
            'as'    => 'acara.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'AcaraController@update',
            'as'    => 'acara.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'AcaraController@delete',
            'as'    => 'acara.delete',
        ]);
    });

    Route::group( ['prefix' => 'dosen'], function() {
        Route::get('/', [
            'uses'  => 'AdminDosenController@index',
            'as'    => 'admin_dosen.index',
        ]);
        Route::get('/add', [
            'uses'  => 'AdminDosenController@create',
            'as'    => 'admin_dosen.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'AdminDosenController@edit',
            'as'    => 'admin_dosen.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'AdminDosenController@all',
            'as'    => 'admin_dosen.all',
        ]);
        Route::post('/check-kaprodi', [
            'uses'  => 'AdminDosenController@checkKaprodi',
            'as'    => 'admin_dosen.check_kaprodi',
        ]);
        Route::post('/store', [
            'uses'  => 'AdminDosenController@store',
            'as'    => 'admin_dosen.store',
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
            'uses'  => 'AdminFakultasController@index',
            'as'    => 'admin_fakultas.index',
        ]);
        Route::get('/add', [
            'uses'  => 'AdminFakultasController@create',
            'as'    => 'admin_fakultas.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'AdminFakultasController@edit',
            'as'    => 'admin_fakultas.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'AdminFakultasController@all',
            'as'    => 'admin_fakultas.all',
        ]);
        Route::post('/store', [
            'uses'  => 'AdminFakultasController@store',
            'as'    => 'admin_fakultas.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'AdminFakultasController@update',
            'as'    => 'admin_fakultas.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'AdminFakultasController@delete',
            'as'    => 'admin_fakultas.delete',
        ]);
    });

    Route::group( ['prefix' => 'prodi'], function() {
        Route::get('/', [
            'uses'  => 'AdminProdiController@index',
            'as'    => 'admin_prodi.index',
        ]);
        Route::get('/add', [
            'uses'  => 'AdminProdiController@create',
            'as'    => 'admin_prodi.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'AdminProdiController@edit',
            'as'    => 'admin_prodi.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'AdminProdiController@all',
            'as'    => 'admin_prodi.all',
        ]);
        Route::post('/store', [
            'uses'  => 'AdminProdiController@store',
            'as'    => 'admin_prodi.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'AdminProdiController@update',
            'as'    => 'admin_prodi.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'AdminProdiController@delete',
            'as'    => 'admin_prodi.delete',
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

    Route::group( ['prefix' => 'kelas'], function() {
        Route::get('/', [
            'uses'  => 'AdminKelasController@index',
            'as'    => 'admin_kelas.index',
        ]);
        Route::get('/{id}/add-session', [
            'uses'  => 'AdminKelasController@create_session',
            'as'    => 'admin_kelas.create_session',
        ]);

        Route::post('/', [
            'uses'  => 'AdminKelasController@all',
            'as'    => 'admin_kelas.all',
        ]);
        Route::post('/store-session', [
            'uses'  => 'AdminKelasController@store_session',
            'as'    => 'admin_kelas.store_session',
        ]);
    });

});

Route::group( ['prefix' => 'dosen'], function() {
    Route::get('/', [ 
        'uses'  => 'DosenController@index',
        'as'    => 'dosen.dashboard',
    ]);
    Route::get('/edit/{id}', [ 
        'uses'  => 'DosenController@edit',
        'as'    => 'dosen.edit',
    ]);

    Route::patch('/update/{id}', [ 
        'uses'  => 'DosenController@update',
        'as'    => 'dosen.update',
    ]);

    Route::group( ['prefix' => 'rencana'], function() {
        Route::get('/', [
            'uses'  => 'RencanaController@index',
            'as'    => 'rencana.index',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'RencanaController@edit',
            'as'    => 'rencana.edit',
        ]);
        Route::get('/pencatatan/{id}', [
            'uses'  => 'RencanaController@pencatatan',
            'as'    => 'rencana.pencatatan'
        ]);
        Route::get('/rps/{id}', [
            'uses'  => 'RencanaController@submatkul',
            'as'    => 'rencana.rps'
        ]);
        Route::get('/rps/{id}/add', [
            'uses'  => 'RencanaController@create',
            'as'    => 'rencana.create',
        ]);
        
        Route::post('/rencana_submatkul', [
            'uses'  => 'RencanaController@rencanaSubMatkul',
            'as'    => 'rencana.rencana_submatkul',
        ]);
        Route::post('/submatkul', [
            'uses'  => 'RencanaController@subMatkulPeriode',
            'as'    => 'rencana.submatkul',
        ]);
        Route::post('/store', [
            'uses'  => 'RencanaController@store',
            'as'    => 'rencana.store',
        ]);
        Route::post('/start_session/{id}', [
            'uses'  => 'RencanaController@start_session',
            'as'    => 'rencana.start_session',
        ]);
        Route::post('/kuliah_store', [
            'uses'  => 'RencanaController@kuliah_store',
            'as'    => 'rencana.kuliah_store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'RencanaController@update',
            'as'    => 'rencana.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'RencanaController@delete',
            'as'    => 'rencana.delete',
        ]);
    });
});

Route::group( ['prefix' => 'kaprodi'], function() {
    Route::get('/', [ 
        'uses'  => 'KaprodiController@index',
        'as'    => 'kaprodi.dashboard',
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

    Route::group( ['prefix' => 'dosen'], function() {
        Route::get('/', [
            'uses'  => 'KaprodiDosenController@index',
            'as'    => 'dosen.index',
        ]);
        Route::get('/add', [
            'uses'  => 'KaprodiDosenController@create',
            'as'    => 'dosen.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'KaprodiDosenController@edit',
            'as'    => 'dosen.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'KaprodiDosenController@all',
            'as'    => 'dosen.all',
        ]);
        Route::post('/store', [
            'uses'  => 'KaprodiDosenController@store',
            'as'    => 'dosen.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'KaprodiDosenController@update',
            'as'    => 'dosen.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'KaprodiDosenController@delete',
            'as'    => 'dosen.delete',
        ]);
    });

    Route::group( ['prefix' => 'matkul'], function() {
        Route::get('/', [
            'uses'  => 'SubMatkulController@index',
            'as'    => 'submatkul.index',
        ]);
        Route::get('/add', [
            'uses'  => 'SubMatkulController@create',
            'as'    => 'submatkul.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'SubMatkulController@edit',
            'as'    => 'submatkul.edit',
        ]);
        Route::get('/{id}/add-session', [
            'uses'  => 'SubMatkulController@create_session',
            'as'    => 'submatkul.create_session',
        ]);
        Route::get('/{id}/dosen', [
            'uses'  => 'SubMatkulController@dosen',
            'as'    => 'submatkul.dosen',
        ]);
        Route::get('/{id}/laporan', [
            'uses'  => 'SubmatkulController@laporan',
            'as'    => 'submatkul.laporan',
        ]);
        
        Route::post('/', [
            'uses'  => 'SubMatkulController@all',
            'as'    => 'submatkul.all',
        ]);
        Route::post('/dosen_submatkul', [
            'uses'  => 'SubMatkulController@dosenSubMatkul',
            'as'    => 'submatkul.dosen_submatkul',
        ]);
        Route::post('/laporan', [
            'uses'  => 'SubMatkulController@laporanSubMatkul',
            'as'    => 'submatkul.submatkul_laporan',
        ]);
        Route::post('/store', [
            'uses'  => 'SubMatkulController@store',
            'as'    => 'submatkul.store',
        ]);
        Route::post('/store-session', [
            'uses'  => 'SubMatkulController@store_session',
            'as'    => 'submatkul.store_session',
        ]);
        Route::post('/dosen_store', [
            'uses'  => 'SubMatkulController@dosen_store',
            'as'    => 'submatkul.dosen_store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'SubMatkulController@update',
            'as'    => 'submatkul.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'SubMatkulController@delete',
            'as'    => 'submatkul.delete',
        ]);
        Route::delete('/pengajar/delete/{id}', [
            'uses'  => 'SubMatkulController@dosen_delete',
            'as'    => 'submatkul.dosen_delete',
        ]);
    });

    Route::group( ['prefix' => 'pengajar'], function() {
        Route::get('/', [
            'uses'  => 'MengajarController@index',
            'as'    => 'mengajar.index',
        ]);
        Route::get('/add', [
            'uses'  => 'MengajarController@create',
            'as'    => 'mengajar.create',
        ]);
        Route::get('/edit/{id}', [
            'uses'  => 'MengajarController@edit',
            'as'    => 'mengajar.edit',
        ]);
        
        Route::post('/', [
            'uses'  => 'MengajarController@all',
            'as'    => 'mengajar.all',
        ]);
        Route::post('/submatkul_data', [
            'uses'  => 'MengajarController@subMatkulPeriode',
            'as'    => 'mengajar.submatkul_data',
        ]);
        Route::post('/store', [
            'uses'  => 'MengajarController@store',
            'as'    => 'mengajar.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'MengajarController@update',
            'as'    => 'mengajar.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'MengajarController@delete',
            'as'    => 'mengajar.delete',
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
});