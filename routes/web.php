<?php

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasienController;


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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index'); 
    Route::resource('pasien', 'PasienController');
    
    Route::resource('dokter', 'DokterController');  
    Route::resource('poliklinik', 'PoliklinikController'); 
    Route::resource('obat', 'ObatController');
    Route::resource('kartu', 'KartuController');
    Route::resource('rekam_medis', 'RekamController');
    Route::post('rekam_medis/detail', 'RekamController@detail')->name('rekam_medis.detail');

    
    Route::get('rekam_medis/detail/rfid', 'RekamController@detail_rfid'); 
    Route::get('rekam_medis/create/rfid', 'RekamController@create_rfid'); 
    //get rfid untuk tambah data kartu pasien
    Route::get('kartu/rfid/get_rfid', 'KartuController@get_rfid'); 
    //get rfid untuk edit data kartu pasien
    Route::get('kartu/{id}/rfid/get_rfid', 'KartuController@get_rfid_edit'); 
    //get rfid untuk tambah data rekam medis
    Route::get('rekam_medis/create/rfid/get_rfid', 'KartuController@get_rfid'); 

    Route::post('/rfid', 'RFIDController@store')->name('rfid.store');


    // Route::resource('admin/role', 'role\RoleController');
    // Route::resource('admin/user', 'user\UserController'); 
    // Route::resource('admin/admin', 'admin\Role_UserController');
});

// Tambahkan rute autentikasi
Auth::routes();

Route::get('/register', 'AuthController@showRegisterForm')->name('register');
Route::post('/register', 'AuthController@register');
Route::get('/login', 'AuthController@showLoginForm')->name('login');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout')->name('logout');
Route::get('/home', 'DashboardController@index')->name('home');

// Routes for authenticated users
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user-home', function () {
        return 'User Home';
    })->name('user.home');
});

// Routes for admins
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-home', function () {
        return 'Admin Home';
    })->name('admin.home');
});

// Jika Anda memiliki rute khusus untuk generate PDF:
Route::get('/pasien_pdf', [PasienController::class, 'Pasien_Pdf'])->name('pasien.pdf');
Route::get('export_excel', 'App\Http\Controllers\PasienController@export_excel')-> name('pasien.export_excel');