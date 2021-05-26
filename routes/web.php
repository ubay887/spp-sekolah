<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function() {
    return redirect(route('login'));
});

Auth::routes(['register' => false]);

//admin
Route::group(['middleware' => 'auth'], function(){
    
    //settings
    Route::group(['middleware' => ['role:admin']], function() {
        Route::get('/setting/aplikasi','SettingController@settingAplikasi')->name('setting.aplikasi');
        Route::get('/setting/payment','SettingController@settingPayment')->name('setting.payment');

        Route::get('/setting/sekolah','SettingController@settingSekolah')->name('setting.sekolah');
        Route::put('/setting/sekolahUpdate/{id}','SettingController@updateSekolah')->name('setting.updateSekolah');

        Route::get('/setting/payment','SettingController@settingPayment')->name('setting.payment');
        Route::put('/setting/paymentUpdate/{id}','SettingController@updatePayment')->name('setting.updatePayment');

        Route::get('/backup', 'Admin\BackupController@index')->name('backup.index');
        Route::get('/backup/proses', 'Admin\BackupController@proses')->name('backup.proses');

        Route::resource('setting', 'SettingController');        
    });
    
    Route::group(['middleware' => ['permission:manajemen users|manajemen roles']], function() {
        Route::get('/roles/search','RoleController@search')->name('roles.search');
        Route::resource('users', 'UserController');
        Route::resource('roles', 'RoleController');
        // Route::resource('setting', 'SettingController');        
    });

    
    //profile
    Route::resource('/profile', 'ProfileController');
    
    // Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){
    //     Route::resource('/tahunajaran', 'TahunAjaranController');
    // });
    
    //tahunajaran
    Route::group(['middleware' => ['permission:manajemen tahun ajaran']], function() {
        Route::resource('/tahunajaran', 'Admin\TahunajaranController');       
    });
    

    //siswa
    Route::group(['middleware' => ['permission:manajemen siswa']], function() {
        Route::get('/siswa/pdf', 'Admin\SiswaController@cetakPdf')->name('siswa.pdf');
        Route::get('/siswa/excel', 'Admin\SiswaController@excel')->name('siswa.excel');
        Route::post('/siswa/import', 'Admin\SiswaController@import')->name('siswa.import');
        Route::post('/siswa/createTagihan', 'Admin\SiswaController@createTagihan')->name('siswa.createTagihan');
        Route::delete('/siswa/deleteTagihan/{id}', 'Admin\SiswaController@deleteTagihan');
        Route::resource('/siswa', 'Admin\SiswaController');               
    });

    //pegawai
    Route::group(['middleware' => ['permission:manajemen pegawai']], function() {      
        Route::resource('/pegawai', 'Admin\PegawaiController');
    });

    //kelas
    Route::group(['middleware' => ['permission:manajemen kelas']], function() {
        Route::resource('/kelas', 'Admin\KelasController');
    });

    //jenispembayaran
    Route::group(['middleware' => ['permission:manajemen jenis pembayaran']], function() {
        Route::resource('/jenispembayaran', 'JenisPembayaranController');
    });

    //transaksi pembayaran
    Route::group(['middleware' => ['permission:manajemen transaksi pembayaran']], function() {
        Route::get('/getSiswa', 'Admin\TransaksiPembayaranController@getSiswa');
        Route::get('/getTagihan/{id}', 'Admin\TransaksiPembayaranController@getTagihan');
        Route::resource('/pembayaran', 'Admin\TransaksiPembayaranController');
        
        Route::get('/cart/addCart', 'Admin\CartController@addCart');
        Route::get('/cart/removeCart', 'Admin\CartController@removeCart');
        // Route::get('/cart/updateCartQty', 'Admin\CartController@updateCartQty');
        Route::delete('/cart/deleteItem/{id}', 'Admin\CartController@deleteItem');
        Route::get('/cartSimpan', 'Admin\CartController@store');
        Route::get('/cart', 'Admin\CartController@index');
    });
    Route::get('/pembayaran/cetak/{id}', 'Admin\TransaksiPembayaranController@cetak')->name('pembayaran.cetak');
    // Route::resource('/cart','Admin\CartController');

    //kenaikankelas / pindah kelas
    Route::group(['middleware' => ['permission:manajemen pindah kelas']], function() {
        Route::get('/kenaikanKelas/proses','Admin\KenaikanKelasController@prosesKenaikanKelas')->name('kenaikanKelas.proses');
        Route::get('/kenaikanKelas/getSiswa','Admin\KenaikanKelasController@getSiswa')->name('kenaikanKelas.getSiswa');
        Route::resource('/kenaikanKelas','Admin\KenaikanKelasController');        
    });
    
    //kelulusan
    Route::group(['middleware' => ['permission:manajemen kelulusan']], function() {
        Route::get('/kelulusan/proses','Admin\KelulusanController@prosesKelulusan')->name('kelulusan.proses');
        Route::get('/kelulusan/alumni','Admin\KelulusanController@getDataAlumni')->name('kelulusan.alumni');
        Route::get('/kelulusan/pindah','Admin\KelulusanController@getDataPindah')->name('kelulusan.pindah');
        Route::get('/kelulusan/dikeluarkan','Admin\KelulusanController@getDataDikeluarkan')->name('kelulusan.dikeluarkan');
        Route::get('/kelulusan','Admin\KelulusanController@index')->name('kelulusan.index'); 
    });

    //laporan pembayaran
    Route::group(['middleware' => ['permission:laporan pembayaran']], function() {
        Route::get('/laporan/pembayaran','Admin\LaporanController@laporanPembayaran')->name('laporan.pembayaran');
        Route::get('/laporan/pembayaranPdf','Admin\LaporanController@laporanPembayaranPdf')->name('laporan.pembayaranPdf');
        Route::get('/laporan/pembayaranExcel','Admin\LaporanController@laporanPembayaranExcel')->name('laporan.pembayaranExcel');      
    });
    
    //laporan tagihan
    Route::group(['middleware' => ['permission:laporan tagihan']], function() {
        Route::get('/laporan/tagihan','Admin\LaporanController@laporanTagihan')->name('laporan.tagihan');
        Route::get('/laporan/tagihanPdf','Admin\LaporanController@laporanTagihanPdf')->name('laporan.tagihanPdf');
        Route::get('/laporan/tagihanExcel','Admin\LaporanController@laporanTagihanExcel')->name('laporan.tagihanExcel');
    });
    

    Route::get('/home', 'HomeController@index')->name('home');
}); 


//siswa
Route::group(['middleware' => 'auth'], function(){
    Route::group(['middleware' => ['permission:manajemen siswa']], function() {
        
        Route::group(['prefix' => 'u', 'namespace' => 'Siswa'], function(){
            // Route::resource('/tahunajaran', 'TahunAjaranController');
            Route::name('u.')->group(function () {
                Route::post('/pass/update/{id}', 'SiswaController@passUpdated')->name('pass.updated');
                Route::get('/gantiPassword', 'SiswaController@gantiPassword')->name('gantiPassword');
                Route::resource('/siswa', 'SiswaController'); 

                Route::get('/getSiswa', 'PembayaranController@getSiswa');
                Route::get('/getTagihan', 'PembayaranController@getTagihan');

                Route::get('/invoice', 'PembayaranController@invoice');
                Route::resource('/pembayaran', 'PembayaranController'); 
                
                Route::get('/cart/addCart', 'CartController@addCart');
                Route::get('/cart/removeCart', 'CartController@removeCart');
                
                Route::delete('/cart/deleteItem/{id}', 'CartController@deleteItem');
                Route::get('/cartSimpan', 'CartController@store');
                Route::get('/cart', 'CartController@index');
                
                // Route::resource('/cart','CartController');

                Route::get('/completed', 'PembayaranController@completed')->name('completed');
            });
        });

    });
});

Route::post('/notifikasi', 'Siswa\PembayaranController@notifikasi')->name('notifikasi');



