@extends('templates.auth.main')

@section('auth')
<div class="row justify-content-center">
  <div class="col-md-5">
    <main class="form-signin m-auto">
      <h1 class="h3 mb-3 fw-normal text-center">Secret Question</h1>
      @if(session('failed'))
      <div class="alert alert-danger">
        {{ session('failed') }}
      </div>
      @endif

      <form class="mb-1" method="POST" action="/auth/secret-question">
        <!-- @method('post') -->
        @csrf
        <div class="form-floating">
          <input type="text" class="form-control mb-2 @error('question') is-invalid @enderror" name="question" id="question" placeholder="email.gmail.com" value="{{ $question }}" disabled>
          <label for="floatingInput">Secret Question</label>
          @error('question')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-floating">
          <input type="text" class="form-control mb-2 @error('answer') is-invalid @enderror" name="answer" id="answer" placeholder="email.gmail.com" }}">
          <label for="floatingInput">Your Answer</label>
          @error('answer')
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
