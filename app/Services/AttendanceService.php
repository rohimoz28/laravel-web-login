<?php

namespace App\Services;

interface AttendanceService
{
  public function getAttendance(): ?object;

  public function getAttendanceEnd(): ?object;
}
