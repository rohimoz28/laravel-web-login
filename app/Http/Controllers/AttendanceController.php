<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
  private AttendanceService $attendanceService;

  public function __construct(AttendanceService $attendanceService)
  {
    $this->attendanceService = $attendanceService;
  }

  public function absence()
  {
    $absence = $this->attendanceService->getAttendance();

    return view('attendance/absence', [
      'title' => 'Absence',
      'user' => User::find(session('id')),
      'absence' => $absence,
    ]);
  }

  public function doAbsence()
  {
    $absence = $this->attendanceService->getAttendance();
    $absence_end = $this->attendanceService->getAttendanceEnd();

    // already absence start?
    if (is_null($absence)) {
      Attendance::create([
        'user_id' => session('id'),
        'date' => date("Y-m-d"),
        'start' => round(microtime(true) * 1000), // getMilis
      ]);

      return redirect('attendance/absence')->with('success', "Absence Success. Have a good day!");
    }

    // already absence end
    if ($absence_end) {
      return redirect('attendance/absence')->with('failed', "You already absence twice!");
    }

    // do absence end
    Attendance::where('user_id', session('id'))
      ->where('date', date("Y-m-d"))
      ->update(['end' => round(microtime(true) * 1000)]);

    return redirect('attendance/absence')->with('success', "Absence Success. See you tomorrow!");
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
