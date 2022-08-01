@extends('templates.app.main')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Edit Profile</h1>
</div>

@if(session('failed'))
<div class="alert alert-danger col-lg-5">
  {{ session('failed') }}
</div>
@endif

<form action="/user/password/{{ $user->id }}" method="POST" class="col-lg-5">
  @method('put')
  @csrf
  <div class="mb-3">
    <label for="currentPassword" class="form-label">Current Password</label>
    <input type="password" name="currentPassword" class="form-control @error('currentPassword') is-invalid @enderror" id="currentPassword">
    @error('currentPassword')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">New Password</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
    @error('password')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="password_confirmation" class="form-label">Retype New Password</label>
    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation">
    @error('password_confirmation')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
    @enderror
  </div>
  <button class="btn btn-primary" type="submit">Update</button>
</form>
@endsection
