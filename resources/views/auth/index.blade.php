@extends('templates.auth.main')

@section('auth')
<div class="row justify-content-center">
  <div class="col-md-5">
    @if(session('loginFailed'))
    <div class="alert alert-danger" role="alert">
      {{ session('status') }}
    </div>
    @endif
    <main class="form-signin w-100 m-auto">
      <h1 class="h3 mb-3 fw-normal text-center">Please Sign In</h1>
      <form class="mb-1" method="POST" action="/auth/index">
        @csrf
        <div class="form-floating">
          <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}">
          <label for="floatingInput">Email address</label>
          @error('email')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-floating">
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password">
          <label for="password">Password</label>
          @error('password')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
      </form>
      <a href="/auth/register" class="w-100 btn btn-lg btn-primary">Register</a>
    </main>
  </div>
</div>
@endsection
