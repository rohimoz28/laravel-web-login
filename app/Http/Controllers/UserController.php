<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('user.index', [
      'title' => 'User Page',
      'user' => User::find(auth()->user()->id),
    ]);
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
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    //
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

  public function editProfile($id)
  {
    return view('user.profile', [
      'title' => 'Update Profile',
      'user' => User::find($id),
    ]);
  }

  public function updateProfile(Request $request, $id)
  {
    $rules = [
      'name' => 'required',
    ];

    $currentEmail = DB::table('users')->where('id', $id)->value('email');

    if ($currentEmail != $request->email) {
      $rules['email'] = 'required|unique:users';
    };

    $validated = $request->validate($rules);

    User::where('id', $id)->update($validated);

    return redirect('/user')->with('success', 'Profile has been updated!');
  }

  public function editPassword($id)
  {
    return view('user.password', [
      'title' => 'Change Password',
      'user' => User::find($id),
    ]);
  }

  public function updatePassword(Request $request, $id)
  {
    $rules = $request->validate([
      'currentPassword' => 'required',
      'password' => 'required|confirmed',
      'password_confirmation' => 'required'
    ], [
      'password.confirmed' => 'Please make sure both passwords match!'
    ]);

    $currentPassword = DB::table('users')->where('id', $id)->value('password');

    // check old password and hashing it
    if (Hash::check($request->currentPassword, $currentPassword)) {
      $rules['password'] =  Hash::make($rules['password']);
      $data = ['password' => $rules['password']];
    }

    User::where('id', $id)->update($data);

    return redirect('/user')->with('success', 'Password has been updated!');
  }
}
