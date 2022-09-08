@extends('templates.app.main')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Your Profile</h1>
</div>

@if(session('success'))
<div class="alert alert-success col-lg-5">
  {{ session('success') }}
</div>
@endif

<div class="card" style="width: 18rem;">
  @if($user->image == 'default.jpeg')
  <img src="storage/profile-pictures/default.jpeg" class="card-img-top" alt="...">
  @else
  <img src="{{ asset('storage/profile-pictures/' . $user->image) }}" class="card-img-top" alt="...">
  @endif
  <div class="card-body">
    <h5 class="card-title">{{ $user->name }}</h5>
    <p class="card-text">{{ $user->email }}</p>
  </div>
</div>
@endsection