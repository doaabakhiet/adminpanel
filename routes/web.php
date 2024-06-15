<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\NeighborhoodController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect('/home');
    } else {
        return redirect('/login');
    }
});
// Route::prefix('admin')->group(function() {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::get('/home', [HomeController::class, 'homeData'])->name('home');

// });
Route::group(['middleware' => ['isAdmin']], function () {
    Route::get('/home', [HomeController::class, 'homeData'])->name('home');
    Route::get('/home-data', [HomeController::class, 'homeData'])->name('home-data');
    Route::resource('settings',SystemController::class);
    Route::resource('services',ServiceController::class);
    Route::resource('areas',AreaController::class);
    Route::resource('cities',CityController::class);
    Route::resource('categories',CategoryController::class);
    Route::resource('objectives',ObjectiveController::class);
    Route::resource('neighborhoods',NeighborhoodController::class);
    Route::resource('infos',InfoController::class);
    Route::resource('ads',AdController::class);
    Route::resource('contact_us',ContactUsController::class);
    Route::resource('subscriptions',SubscriptionController::class);
    Route::resource('company',CompanyController::class);
    Route::resource('clients',ClientController::class);
    Route::resource('property_type',PropertyTypeController::class);
    
});
// Auth::routes();

