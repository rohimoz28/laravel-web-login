<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{

  public function absence(Request $request)
  {
    $id = $request->session()->get('id');
    $date = date("Y-m-d");

    $attendances = DB::table('attendances')
      ->where('user_id', $id)
      ->where('date', $date)
      ->first();
    // return $attendances;

    return view('attendance/absence', [
      'title' => 'Absence',
      'user' => User::find($id),
      'attendances' => $attendances,
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

    if (is_null($absence_now)) {  //hari ini sudah absen datang?
      Attendance::create([
        'user_id' => $id,
        'date' => $date_now,
        'start' => $epoch,
      ]);
      return "Absen datang berhasil";
    } else {
      // sudah absen pulang?
      $absence_end = DB::table('attendances')
        ->where('user_id', $id)
        ->where('date', $date_now)
        ->whereNotNull('end')
        ->first();

      if ($absence_end) {
        return 'Besok lagi absennya!';
      } else {
        //belum absen pulang
        DB::table('attendances')
          ->where('user_id', $id)
          ->where('date', $date_now)
          ->update(['end' => $epoch]);
        return "Absen pulang berhasil";
      }
    }
  }

  public function list(Request $request)
  {
    $id = $request->session()->get('id');
    $months = [
      1 => 'January',
      2 => 'February',
      3 => 'Maret',
      4 => 'April',
      5 => 'May',
      6 => 'June',
      7 => 'July',
      8 => 'August',
      9 => 'September',
      10 => 'October',
      11 => 'November',
      12 => 'December'
    ];


    $search = $request->input('search');
    $month = date("m");

    if ($search = $request->input('search')) { 
      $attendances = DB::table('attendances')
        ->where('user_id', $id)
        ->whereMonth('date', $search)
        ->orderBy('date', 'desc')
        ->paginate(6);

      $attendances->appends(['search' => $search]);

      return view('attendance/attendance-list', [
        'title' => 'List',
        'user' => User::find($id),
        'attendances' => $attendances,
        'months' => $months,
      ]);
    } else {
      $attendances = DB::table('attendances')
        ->where('user_id', $id)
        ->whereMonth('date', $month)
        ->orderBy('date', 'desc')
        ->paginate(6);

      return view('attendance/attendance-list', [
        'title' => 'List',
        'user' => User::find($id),
        'attendances' => $attendances,
        'months' => $months,
      ]);
    }
  }

  public function search(Request $request)
  {
    $user_ID = $request->session()->get('id');
    $month = $request->input('search');

    $months = [
      1 => 'January',
      2 => 'February',
      3 => 'Maret',
      4 => 'April',
      5 => 'May',
      6 => 'June',
      7 => 'July',
      8 => 'August',
      9 => 'September',
      10 => 'October',
      11 => 'November',
      12 => 'December'
    ];
    // $search = $request->input('search');

    $attendances = DB::table('attendances')
      ->where('user_id', $user_ID)
      ->whereMonth('date', $month)
      ->orderBy('date', 'desc')
      ->paginate(6);

    return view('attendance/attendance-list', [ //should not return a view
      'title' => 'List',
      'user' => User::find($user_ID),
      'attendances' => $attendances,
      'months' => $months,
    ]);
  }
}
