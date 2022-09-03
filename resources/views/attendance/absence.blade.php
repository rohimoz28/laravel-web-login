@extends('templates.app.main')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Absence: {{ $user->name }}</h1>
</div>

@if(session('success'))
<div class="alert alert-success col-lg-5">
  {{ session('success') }}
</div>
@endif

<div class="col-lg-5">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">Date</th>
        <th scope="col">Start</th>
        <th scope="col">End</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">{{ date('Y-m-d')  }}</th>
        <td>{{ (is_null($attendances)) ? 'Not Yet' : date("H:i:s", substr($attendances->start, 0, 10)) }}</td>
        <td>{{ (is_null($attendances) || is_null($attendances->end)) ? 'Not Yet' : date("H:i:s", substr($attendances->end, 0, 10)) }}</td>
      </tr>
    </tbody>
  </table>
</div>

<div class="col-lg-4">
  <form action="/attendance/absence/<?= $user->id ?>" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary btn-lg" name="submit">Enroll</button>
  </form>
</div>

@endsection
