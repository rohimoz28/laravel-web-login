@extends('templates.app.main')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Attendance List: {{ $user->name }}</h1>
</div>

@if(session('success'))
<div class="alert alert-success col-lg-5">
  {{ session('success') }}
</div>
@endif

<div class="col-lg-5 mb-5">
  <select class="form-select" aria-label="Default select example">
    <option selected>Select Month</option>
    <option value="1">August</option>
    <option value="2">July</option>
    <option value="3">June</option>
  </select>
</div>

<div class="col-lg-10">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">Date</th>
        <th scope="col">Start</th>
        <th scope="col">End</th>
      </tr>
    </thead>
    <tbody>
      @foreach($attendances as $attendance)
      <tr>
        <th scope="row">{{ $attendance->date }}</th>
        <td>{{ (is_null($attendance->start)) ? 'Not Yet' : date("H:i:s", substr($attendance->start, 0, 10)) }}</td>
        <td>{{ (is_null($attendance->start)) ? 'Not Yet' : date("H:i:s", substr($attendance->start, 0, 10)) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
