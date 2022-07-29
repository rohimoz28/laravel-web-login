@extends('templates.auth.main')

@section('auth')
<div class="row justify-content-center">
  <div class="col-md-5">
    <main class="form-signin m-auto">
      <h1 class="h3 mb-3 fw-normal text-center">Forgot Password</h1>
      @if(session('failed'))
      <div class="alert alert-danger">
        {{ session('failed') }}
      </div>
      @endif
      <form class="mb-1" method="POST" action="/auth/forgot">
        @method('put')
        @csrf
        <div class="form-floating">
          <input type="email" class="form-control mb-2 @error('email') is-invalid @enderror" name="email" id="email" placeholder="email.gmail.com" value="{{ old('email') }}">
          <label for="floatingInput">Email address</label>
          @error('email')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-floating">
          <input type="password" class="form-control mb-2 @error('password') is-invalid @enderror" placeholder="New Password" name="password" id="password" >
          <label for="floatingInput">New password</label>
          @error('password')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-floating">
          <input type="password" class="form-control mb-2 @error('password_confirmation') is-invalid @enderror" placeholder="Retype Password" id="password_confirmation" name="password_confirmation">
          <label for="password">Retype new password</label>
          @error('password_confirmation')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>
        <button class="w-100 btn btn-lg btn-success" type="submit">Submit</button>
      </form>
      <a href="/auth/index" class="w-100 btn btn-lg btn-primary">Back to login</a>
    </main>
  </div>
</div>
@endsection
