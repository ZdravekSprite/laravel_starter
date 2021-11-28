<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    Blade::if('hasroles', function ($expression) {
      if (Auth::check()) {
        $user = User::where('id', '=', Auth::id())->first();
        if ($user->hasAnyRoles($expression)) {
          return true;
        }
      }
      return false;
    });

    Blade::if('hasrole', function ($expression) {
      if (Auth::check()) {
        $user = User::where('id', '=', Auth::id())->first();
        if ($user->hasAnyRole($expression)) {
          return true;
        }
      }
      return false;
    });
  }
}
