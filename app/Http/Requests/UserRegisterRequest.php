<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'name' => 'required',
      'username' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|confirmed',
      'question' => 'notIn:0',
      'answer' => 'required',
      'image' => 'image|file|max:2048',
    ];
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'question.not_in' => 'You need to choose the :attribute'
    ];
  }
}
