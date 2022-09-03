<?php

namespace App\Providers;

use App\Services\AttendanceService;
use App\Services\Impl\AttendanceServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AttendanceServiceProvider extends ServiceProvider implements DeferrableProvider
{
  public array $singletons = [
    AttendanceService::class => AttendanceServiceImpl::class
  ];

  public function provides(): array
  {
    return [AttendanceService::class];
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
