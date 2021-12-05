<?php

use App\Http\Controllers\Admin\ImpersonateController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

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
      'edit', 'update', 'show'
    ]);
  Route::get('/impersonate/{id}', [ImpersonateController::class, 'start'])->name('impersonate.start');
});

Route::get('login/{provider}', function ($provider) {
  return Socialite::driver($provider)->redirect();
})->name('{provider}Login');
Route::get('login/{provider}/callback', function ($provider) {
  $social_user = Socialite::driver($provider)->user();
  // $user->token
  $user = User::firstOrCreate([
    'email' => $social_user->getEmail(),
  ]);
  if (!$user->name) {
    $user->name = $social_user->getName();
  }
  if (!$user[$provider . "_id"]) {
    $user[$provider . "_id"] = $social_user->getId();
  }
  if ($social_user->getAvatar()) {
    if($provider == 'facebook') {
      $url = $social_user->getAvatar() . '&access_token=' . $social_user->token;
      $ch = curl_init();
  
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
  
      $res = curl_exec($ch);
      $redirectedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
      //$avatar = ltrim($redirectedUrl,"https://");
      $avatar = $redirectedUrl;
    } else {
      $avatar = $social_user->getAvatar();
    }
    if (!$user->avatar) {
      $user->avatar = $avatar;
    }
    if (!$user[$provider . "_avatar"]) {
      $user[$provider . "_avatar"] = $avatar;
    }
  }
  if (!$user->roles->pluck('name')->contains('socialuser')) {
    $socialUserRole = Role::where('name', 'socialuser')->first();
    $user->roles()->attach($socialUserRole);
  }
  $user->save();
  Auth::Login($user, true);
  return redirect(route('home'));
})->name('{provider}Callback');
