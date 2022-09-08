<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
  private AttendanceService $attendanceService;

  public function __construct(AttendanceService $attendanceService)
  {
    $this->attendanceService = $attendanceService;
  }

  public function absence()
  {
    $absence = $this->attendanceService->getUserAttendance();

    return view('attendance/absence', [
      'title' => 'Absence',
      'user' => User::find(session('id')),
      'absence' => $absence,
    ]);
  }

  public function doAbsence()
  {
    $absence = $this->attendanceService->getUserAttendance();
    $absence_end = $this->attendanceService->getAttendanceEnd();

    // absence start already?
    if (is_null($absence)) {
      Attendance::create([
        'user_id' => session('id'),
        'date' => date("Y-m-d"),
        'start' => round(microtime(true) * 1000), // getMilis
      ]);

      return redirect('attendance/absence')->with('success', "Absence Success. Have a good day!");
    }

    // absence end already?
    if ($absence_end) {
      return redirect('attendance/absence')->with('failed', "You already absence twice!");
    }

    // then do absence end
    Attendance::where('user_id', session('id'))
      ->where('date', date("Y-m-d"))
      ->update(['end' => round(microtime(true) * 1000)]); //update column end

    return redirect('attendance/absence')->with('success', "Absence Success. See you tomorrow!");
  }

  public function list(Request $request)
  {
    // check search keyword
    if ($request->input('search')) {  
      $attendances =  $this->attendanceService->search($request->input('search'));
    } else {
      $attendances = $this->attendanceService->getAttendanceList();
    }

    return view('attendance/attendance-list', [
      'title' => 'List',
      'user' => User::find(session('id')),
      'attendances' => $attendances,
      'months' => config('app.months'),
    ]);
  }
}
