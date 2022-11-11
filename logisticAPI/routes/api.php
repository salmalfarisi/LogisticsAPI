<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 
Route::post('/register', [LoginController::class, 'Register']);
Route::post('/login', [LoginController::class, 'Login']);

Route::middleware(['token'])->group(function () {
	Route::get('/logout', [LoginController::class, 'Logout']);
	Route::prefix('category-products')->controller(CategoryController::class)->group(function () {
		Route::get('/', 'index');
		Route::get('/{id}', 'show');
		Route::post('/', 'store');
		Route::put('/{id}', 'update');
		Route::delete('/{id}', 'destroy');
	});
	
	Route::prefix('products')->controller(ProductController::class)->group(function () {
		Route::get('/', 'index');
		Route::get('/{id}', 'show');
		Route::post('/', 'store');
		Route::post('/{id}', 'update');
		Route::delete('/{id}', 'destroy');
	});
});
