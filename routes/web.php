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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UsersListController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\RolesListController;
use Illuminate\Support\Facades\Auth;

            

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/users-management', [UsersListController::class, 'list'])->name('user-management');
	Route::post('/users/delete', [UsersListController::class, 'delete'])->name('users.delete');
	Route::post('/users/add', [UsersListController::class, 'add'])->name('users.add');
	Route::post('/users/edit', [UsersListController::class, 'edit'])->name('users.edit');

	Route::get('/roles-management', [RolesListController::class, 'list'])->name('role-management');


	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');

});