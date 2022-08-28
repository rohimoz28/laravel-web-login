@extends('templates.auth.main')

@section('auth')
<div class="row justify-content-center">
  <div class="col-md-5">
    <main class="form-signin m-auto">
      <h1 class="h3 mb-3 fw-normal text-center">Update Password</h1>
      @if(session('failed'))
      <div class="alert alert-danger">
        {{ session('failed') }}
      </div>
      @endif

      <form class="mb-1" method="POST" action="/auth/update-password">
        @csrf
        <div class="form-floating">
          <input type="password" class="form-control mb-2 @error('password') is-invalid @enderror" name="password" id="password" placeholder="password">
          <label for="floatingInput">New Password</label>
          @error('password')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-floating">
          <input type="password" class="form-control mb-2 @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="retype password">
          <label for="floatingInput">Retype Password</label>
          @error('password_confirmation')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>
        <button class="w-100 btn btn-lg btn-success" type="submit">Submit</button>
      </form>
    </main>
  </div>
</div>
@endsection
