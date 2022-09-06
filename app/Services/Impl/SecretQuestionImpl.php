<?php

namespace App\Services\Impl;

use App\Services\SecretQuestionService;

class SecretQuestionImpl implements SecretQuestionService
{

  public function checkAnswer($email, $answer): bool
  {
    $user = $this->getUser($email);

    return ($user->answer === $answer) ? true : false;
  }

}
