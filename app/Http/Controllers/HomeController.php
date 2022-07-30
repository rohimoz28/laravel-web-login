<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  public function home(): RedirectResponse
  {
    if (Auth::check()) {
      return redirect('/user');
    } else {
      return redirect('auth/index');
    }
  }
}
