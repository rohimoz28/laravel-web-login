<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAnswerRequest;
use App\Http\Requests\UserEmailRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Models\SecretQuestion;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
  public function store(UserRegisterRequest $request)
  {
    if (!$request->hasFile('image')) {
      $image = 'default.jpeg';
    } else {
      // $image = $request->image->store('profile-pictures');
      $image = $request->file('image');
      $image->storeAs('profile-pictures', $image->hashName());
      $image = $image->hashName();
    }

    DB::beginTransaction();
    try {
      $user = User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => Hash::make($request['password']),
        'image' => $image
      ]);

      $last_inserted_ID = $user->id;

      SecretQuestion::create([
        'user_id' => $last_inserted_ID,
        'question' => $request['question'],
        'answer' => $request['answer']
      ]);
      DB::commit();
      return redirect('/')->with('success', 'Registration success, Please Login.');
    } catch (\Exception $exception) {

      DB::rollBack();
      return $exception->getMessage();
    }
  }

  public function checkEmail()
  {
    return view('auth.check-email', [
      'title' => 'Forgot Password',
    ]);
  }

  public function doCheckEmail(UserEmailRequest $request)
  {
    $user = $this->userService->userQuestion($request->input('email'));

    if (!$user) {
      return redirect()->to('check-email')->with('failed', 'Email not registered!');
    }
    // generate cookie
    $email = $user->email;
    // redirect to cek secret question
    return redirect()->to('/secret-question')
      ->withCookie('X-COOKIE-FORGOTPASSWORD', $email);
  }

  public function secretQuestion(Request $request)
  {
    $user = $this->userService->userQuestion($request->cookie('X-COOKIE-FORGOTPASSWORD'));

    return view('auth.secret-question', [
      'title' => 'Forgot Password',
      'question' => $user->question,
    ]);
  }

  public function checkAnswer(UserAnswerRequest $request)
  {
    $user = $this->userService->userQuestion($request->cookie('X-COOKIE-FORGOTPASSWORD'));

    $answer = $request->input('answer');
    $correct_answer = $user->answer;

    if ($answer !== $correct_answer) {
      return redirect()->to('/secret-question')->with('failed', 'Your answer is wrong!');
    }

    return redirect()->to('/update-password');
  }

  public function updatePassword(Request $request)
  {
    $user = $this->userService->userQuestion($request->cookie('X-COOKIE-FORGOTPASSWORD'));

    return view('auth.update-password', [
      'title' => 'Update Password',
      'user' => User::find($user->id),
    ]);
  }

  public function doUpdatePassword(UserUpdatePasswordRequest $request)
  {
    $user = $this->userService->userQuestion($request->cookie('X-COOKIE-FORGOTPASSWORD'));

    $user_update = User::find($user->id);
    $user_update->password = Hash::make($request->input('password'));

    $user_update->save();

    return redirect('/')->withoutCookie('X-COOKIE-FORGOTPASSWORD')->with('success', 'Password has been updated!');
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
}
