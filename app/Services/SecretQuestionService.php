<?php

namespace App\Services;

interface SecretQuestionService
{
  public function checkAnswer(string $email, string $answer): bool;
}
