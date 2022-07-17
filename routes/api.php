<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

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

Route::controller(AuthController::class)->group(function() {
  Route::post('register', 'register');
  Route::post('login', 'login');
  Route::get('logout', 'logout');
  Route::get('halo', 'hallo');
});

Route::controller(BookController::class)->group(function() {
  Route::post('library/add-book', 'createBook');
  Route::get('library/list-book', 'listBook');
  Route::get('library/detail-book/{id}', 'singleBook');
  Route::post('library/edit-book/{id}', 'updateBook');
  Route::delete('library/delete-book/{id}', 'deleteBook');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
