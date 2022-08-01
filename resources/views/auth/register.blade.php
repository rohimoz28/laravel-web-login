@extends('templates.auth.main')

@section('auth')
<div class="row justify-content-center">
  <div class="col-md-5">
    <main class="form-signin m-auto">
      <h1 class="h3 mb-3 fw-normal text-center">Registration Form</h1>
      @if(session('failed'))
      <div class="alert alert-danger">
        {{ session('failed') }}
      </div>
      @endif
      <form class="mb-1" method="POST" action="/auth/register" enctype="multipart/form-data">
        @csrf
        <div class="form-floating">
          <input type="text" class="form-control mb-2 @error('name') is-invalid @enderror" name="name" id="floatingInput" placeholder="name@example.com" value="{{ old('name') }}">
          <label for="floatingInput">Name</label>
          @error('email')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>
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
        <div class="form-floating">
          <input type="password" class="form-control mb-2 @error('retypePassword') is-invalid @enderror" id="password_confirmation" placeholder="Retype Password" name="password_confirmation">
          <label for="retypePassword">Retype Password</label>
          @error('password')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>
        <!-- imagePreview -->
        <!-- <div class="mb-3"> -->
        <!--   <label for="image" class="form-label">Post Image</label> -->
        <!--   <input class="form-control  @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()"> -->
        <!--   <img class="img-preview img-fluid my-3 col-sm-5"> -->
        <!--   @error('image') -->
        <!--   <div class="invalid-feedback"> -->
        <!--     {{ $message }} -->
        <!--   </div> -->
        <!--   @enderror -->
        <!-- </div> -->
        <div class="mb-3">
          <!-- <label for="formFile" class="form-label">Default file input example</label> -->
          <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image">
          @error('image')
          <div class="invalid-feedback text-start">
            {{ $message }}
          </div>
          @enderror
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Submit</button>
      </form>
      <a href="/auth/index" class="w-100 btn btn-lg btn-primary">Back to login</a>
    </main>
  </div>
</div>

<!-- <script> -->
<!--   //image -->
<!--   function previewImage() { -->
<!--     const image = document.querySelector('#image'); -->
<!--     const imgPreview = document.querySelector('.img-preview'); -->
<!--     imgPreview.style.display = 'block'; -->
<!--     const oFReader = new FileReader(); -->
<!--     oFReader.readAsDataURL(image.files[0]); -->
<!--     oFReader.onload = function(oFREvent) { -->
<!--       imgPreview.src = oFREvent.target.result; -->
<!--     } -->
<!--   } -->
<!-- </script> -->
@endsection
