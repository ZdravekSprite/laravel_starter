<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //dd(User::paginate(10));
    if (request()->is('api/*')) {
      //an api call
      return User::paginate(10);
    } else {
      //a web call
      $users = User::paginate(10);
      $vueusers = User::all();
      return view('admin.users.index')->with(compact('users','vueusers'));
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
    if (request()->is('api/*')) {
      //an api call
      return $user;
    } else {
      //a web call
      return view('admin.users.show')->with(compact('user'));
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    $auth = User::where('id', '=', Auth::id())->first();
    if (!$auth->hasAnyRole('superadmin') && $user->hasAnyRole('superadmin')) {
      return redirect(route('users.index'))->with('status', 'You are not allowed to edit superadmin.');
    }
    return view('admin.users.edit')->with(['user' => $user, 'roles' => Role::all()]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
  {
    $user->roles()->sync($request->roles);
    return redirect(route('users.index'))->with('status', 'User updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    //
  }
}
