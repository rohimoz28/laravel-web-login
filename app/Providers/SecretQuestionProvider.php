<?php

namespace App\Providers;

use App\Services\Impl\SecretQuestionImpl;
use App\Services\SecretQuestionService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class SecretQuestionProvider extends ServiceProvider implements DeferrableProvider
{
  public array $singletons = [
    SecretQuestionService::class => SecretQuestionImpl::class
  ];

  public function provides(): array
  {
    return [SecretQuestionService::class];
  }

  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
