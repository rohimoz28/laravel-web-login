<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
  private UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }
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

    $this->userService->updateProfile($request->all(), $id);

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
    $this->userService->updatePassword($request->all(), $id);

    return redirect('/user')->with('success', 'Password has been updated!');
  }
}
