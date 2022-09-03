<?php

namespace App\Services;

interface AttendanceService
{
  public function getUserAttendance(): ?object;

  public function getAttendanceEnd(): ?object;

  public function getAttendanceList(): ?object;

  public function search(string $search): ?object;
}
