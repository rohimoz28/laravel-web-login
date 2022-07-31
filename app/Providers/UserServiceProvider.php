<?php

namespace App\Providers;

use App\Services\Impl\UserServiceImpl;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
  public array $singletons = [
    UserService::class => UserServiceImpl::class,
  ];
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    return [UserService::class];
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
