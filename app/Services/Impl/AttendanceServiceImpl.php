<?php

namespace App\Services\Impl;

use App\Services\AttendanceService;
use Illuminate\Support\Facades\DB;

class AttendanceServiceImpl implements AttendanceService
{
  public function getUserAttendance(): ?object
  {
    $epoch = round(microtime(true) * 1000);
    $date = date("Y-m-d", substr($epoch, 0, 10));

    $attendances = DB::table('attendances')
      ->where('user_id', session('id'))
      ->where('date', $date)
      ->first();

    return $attendances;
  }

  public function getAttendanceEnd(): ?object
  {
    $epoch = round(microtime(true) * 1000);
    $date = date("Y-m-d", substr($epoch, 0, 10));

    $attendanceEnd = DB::table('attendances')
      ->where('user_id', session('id'))
      ->where('date', $date)
      ->whereNotNull('end')
      ->first();

    return $attendanceEnd;
  }

  public function getAttendanceList(): ?object
  {
    $attendances = DB::table('attendances')
      ->where('user_id', session('id'))
      ->orderBy('date', 'desc')
      ->paginate(6);

    return $attendances;
  }

  public function search(string $search): ?object
  {
    $attendances = DB::table('attendances')
      ->where('user_id', session('id'))
      ->whereMonth('date', $search)
      ->orderBy('date', 'desc')
      ->paginate(6);

    return $attendances->appends(['search' => $search]);
  }
}
