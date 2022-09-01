<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{

  public function absence($id)
  {

    $date = date("Y-m-d");
    $attendance = DB::table('users')
      ->join('attendances', 'users.id', '=', 'attendances.user_id')
      ->select('users.*', 'attendances.*')
      ->where('attendances.date', $date)
      ->where('attendances.user_id', $id)
      ->first();

    return view('attendance/absence', [
      'title' => 'Absence',
      'user' => User::find($id),
      'attendances' => $attendance,
    ]);
  }

  public function doAbsence($id)
  {
    $epoch = round(microtime(true) * 1000);
    $date_now = date("Y-m-d", substr($epoch, 0, 10));
    // return $date_now;

    $absence_now = DB::table('attendances')
      ->where('user_id', $id)
      ->where('date', $date_now)
      ->first();


    if (is_null($absence_now)) {
      Attendance::create([
        'user_id' => $id,
        'date' => $date_now,
        'start' => $epoch,
      ]);
      return "Absen datang berhasil";
    } else {
      DB::table('attendances')
        ->where('user_id', $id)
        ->where('date', $date_now)
        ->update(['end' => $epoch]);
      return "Absen pulang berhasil";
    }
  }

  public function list($id)
  {
    return view('attendance/attendance-list', [
      'title' => 'List',
      'user' => User::find($id),
    ]);
  }
}
