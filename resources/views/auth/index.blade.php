@extends('templates.auth.main')

@section('auth')
<div class="row justify-content-center">
  <div class="col-md-5">
    <main class="form-signin m-auto">
      <h1 class="h3 mb-3 fw-normal text-center">Please Sign In</h1>
      @if(session('failed'))
      <div class="alert alert-danger">
        {{ session('failed') }}
      </div>
      @endif

      @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif
      <form class="mb-1" method="POST" action="/auth/index">
        @csrf
        <div class="form-floating">
          <input type="email" class="form-control mb-2 @error('email') is-invalid @enderror" name="email" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}">
          <label for="floatingInput">Email address</label>
          @error('email')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-floating">
          <input type="password" class="form-control mb-2 @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password">
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
      <a href="/auth/forgot" class="w-100 btn btn-lg btn-danger mt-1">Forgot Password</a>
    </main>
  </div>
</div>
@endsection
