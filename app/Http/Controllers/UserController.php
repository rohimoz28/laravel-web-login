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

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('auth.register', [
      'title' => 'Registration'
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->userService->register($request->all());

    //redirect
    return redirect('auth/index')->with('success', 'Registration success, Please Login.');
  }
}
