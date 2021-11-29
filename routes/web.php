<?php

use App\Http\Controllers\Admin\ImpersonateController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
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

Route::view('/', 'welcome')->name('home');
/*
Route::get('/', function () {
  return view('welcome');
})->name('home');
*/
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
Route::get('admin/impersonate/stop', [ImpersonateController::class, 'stop'])->name('impersonate.stop');
Route::prefix('admin')->middleware(['auth.admin'])->group(function () {
//Route::prefix('admin')->middleware(['auth.admin'])->name('admin.')->group(function () {
  Route::resource('roles', RoleController::class)
    ->only([
      'index'
    ]);
  Route::resource('role', RoleController::class)
    ->except([
      'index'
    ])
    ->missing(function (Request $request) {
      return redirect(route('roles.index'));
    });

  Route::resource('users', UserController::class)
    ->only([
      'index'
    ]);
  Route::resource('user', UserController::class)
    ->missing(function (Request $request) {
      return Redirect::route('users.index');
    })
    ->only([
      'edit', 'update'
    ]);
  Route::get('/impersonate/{id}', [ImpersonateController::class, 'start'])->name('impersonate.start');
});
