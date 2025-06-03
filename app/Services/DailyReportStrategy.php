<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ReportInterface;

class DailyReportStrategy implements ReportInterface
{
   public function generate(User $user, array $filters)
    {
        return $user->timeLogs()
            ->select(
                DB::raw('DATE(start_time) as date'),
                DB::raw('SUM(hours) as total_hours')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
