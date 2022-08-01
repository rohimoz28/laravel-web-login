<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\Impl\AuthServiceImpl;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
  public array $singletons = [
    AuthService::class => AuthServiceImpl::class
  ];
  /**
   * The policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */

  public function register()
  {
    return [AuthService::class];
  }
  protected $policies = [
    // 'App\Models\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    // $this->registerPolicies();

    //
  }
}
