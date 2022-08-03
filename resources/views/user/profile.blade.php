@extends('templates.app.main')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Edit Profile</h1>
</div>

<form action="/user/profile/{{ $user->id }}" method="POST" class="col-lg-5" enctype="multipart/form-data">
  @method('put')
  @csrf
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $user->name) }}">
    @error('name')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $user->email) }}">
    @error('email')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="image" class="form-label">User Image</label>
    <input type="hidden" name="oldImage" value="{{ $user->image }}">
    @if($user->image == 'default.jpeg')
    <img src="{{ asset('profile-pictures/default.jpeg') }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
    @else
    <img src="{{ asset('storage/' . $user->image) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
    @endif
    <!-- <img class="img-preview img-fluid mb-3 col-sm-5 d-block" src="{{ $user->image ? asset('storage/' . $user->image) : '' }}"> -->
    <input class=" form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
    @error('image')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
    @enderror
  </div>
  <button class="btn btn-primary mb-5" type="submit">Update</button>
</form>

<script>
  function previewImage() {
    const image = document.querySelector('#image');
    const imgPreview = document.querySelector('.img-preview');
    imgPreview.style.display = 'block';
    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);
    oFReader.onload = function(oFREvent) {
      imgPreview.src = oFREvent.target.result;
    }
  }
</script>
@endsection
