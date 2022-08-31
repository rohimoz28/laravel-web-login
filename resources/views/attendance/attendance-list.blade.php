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
      <tr>
        <th scope="row">31/08/2022</th>
        <td>10:10:10</td>
        <td></td>
      </tr>
      <tr>
        <th scope="row">30/08/2022</th>
        <td>10:10:10</td>
        <td>05:05:05</td>
      </tr>
      <tr>
        <th scope="row">29/08/2022</th>
        <td>10:10:10</td>
        <td>05:05:05</td>
      </tr>
    </tbody>
  </table>
</div>
@endsection
