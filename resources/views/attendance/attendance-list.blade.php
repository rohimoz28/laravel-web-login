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
<div class="col-lg-5">
  <form class="row row-cols-lg-auto g-3 align-items-center" action="" method="GET">
    <div class="col-10">
      <label class="visually-hidden" for="inlineFormSelectPref">Preference</label>
      <select class="form-select" id="inlineFormSelectPref" name="search">
        <option selected>Choose...</option>
        @foreach($months as $number => $month)
        <option value="{{ $number }} {{ old('search') == $number ? 'selected' :  '' }}">{{ $month }}</option>
        @endforeach
      </select>
    </div>

    <div class=" col-12">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>

  <div class="col-lg-10 mt-5">
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
          <th scope="row">{{ is_null($attendance) ? date("Y-m-d") : $attendance->date }}</th>
          <td>{{ (is_null($attendance->start)) ? 'Not Yet' : date("H:i:s", substr($attendance->start, 0, 10)) }}</td>
          <td>{{ (is_null($attendance->end)) ? 'Not Yet' : date("H:i:s", substr($attendance->end, 0, 10)) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $attendances->onEachSide(5)->links() }}
  </div>
  @endsection
