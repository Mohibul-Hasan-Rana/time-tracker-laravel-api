<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ReportInterface;

class ClientReportStrategy implements ReportInterface
{
    public function generate(User $user, array $filters)
    {
        return $user->timeLogs()
            ->join('projects', 'time_logs.project_id', '=', 'projects.id')
            ->join('clients', 'projects.client_id', '=', 'clients.id')
            ->select(
                'clients.id',
                'clients.name',
                DB::raw('SUM(time_logs.hours) as total_hours')
            )
            ->groupBy('clients.id', 'clients.name')
            ->orderBy('clients.name')
            ->get();
    }
}
