@extends('templates.auth.main')

@section('auth')
<div class="row justify-content-center">
  <div class="col-md-5">
    <main class="form-signin m-auto">
      <h1 class="h3 mb-3 fw-normal text-center">Email Validation</h1>
      @if(session('failed'))
      <div class="alert alert-danger">
        {{ session('failed') }}
      </div>
      @endif

      <form class="mb-1" method="POST" action="/auth/check-email">
        <!-- @method('post') -->
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
        <button class="w-100 btn btn-lg btn-success" type="submit">Submit</button>
      </form>
      <a href="/auth/index" class="w-100 btn btn-lg btn-primary">Back to login</a>
    </main>
  </div>
</div>
@endsection
