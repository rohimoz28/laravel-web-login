<?php

namespace App\Http\Controllers;

use App\Services\SecretQuestionService;
use Illuminate\Http\Request;

class SecretQuestion extends Controller
{
  private SecretQuestionService $secretQuestionService;

  public function __construct(SecretQuestionService $secretQuestionService)
  {
    $this->secretQuestionService = $secretQuestionService;
  }

  public function secretQuestion(Request $request)
  {
    $question = $request->session()->get('question');

    return view('auth.secret-question', [
      'title' => 'Secret Question',
      'question' => $question
    ]);
  }

  public function checkAnswer(Request $request)
  {
    $email = $request->session()->get('email');
    $answer = $request->input('answer');

    // $is_answer = $this->authService->checkAnswer($email, $answer);
    $is_answer = $this->secretQuestionService->checkAnswer($email, $answer);

    if (!$is_answer) {
      return redirect()->to('auth/secret-question')->with('failed', 'Your answer is wrong!');
    }

    return redirect()->to('auth/update-password');
  }
}
