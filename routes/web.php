<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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
})->name('home');

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
/*
Route::resources([
  'roles' => RoleController::class,
  'users' => UserController::class,
]);
*/
Route::resource('roles', RoleController::class)
  ->missing(function (Request $request) {
    return redirect(route('roles.index'));
  });
Route::resource('users', UserController::class)
  ->missing(function (Request $request) {
    return Redirect::route('users.index');
  })
  ->only([
    'index', 'edit', 'update'
  ]);
