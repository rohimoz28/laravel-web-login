<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\SecretQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateController extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(UserRegisterRequest $request)
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

      return response()->json([
        'success' => true,
        'message' => 'Registration success, Please Login.',
      ]);
    } catch (\Exception $exception) {

      DB::rollBack();
      return response()->json([
        'success' => true,
        'message' => $exception->getMessage(),
      ]);
    }
  }
}
