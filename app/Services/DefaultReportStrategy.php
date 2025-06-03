<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ReportInterface;

class DefaultReportStrategy implements ReportInterface
{
    public function generate(User $user, array $filters)
    {
        $query = $user->timeLogs()
            ->with(['project.client'])
            ->orderBy('start_time', 'desc');

        // Apply filters
        if (isset($filters['client_id'])) {
            $query->whereHas('project', function ($q) use ($filters) {
                $q->where('client_id', $filters['client_id']);
            });
        }

        if (isset($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        if (isset($filters['from'])) {
            $query->whereDate('start_time', '>=', $filters['from']);
        }

        if (isset($filters['to'])) {
            $query->whereDate('start_time', '<=', $filters['to']);
        }

        if (isset($filters['tag'])) {
            $query->where('tag', $filters['tag']);
        }

        $logs = $query->get();

        return collect([
            'logs' => $logs,
            'total_hours' => $logs->sum('hours'),
        ]);
        
    }
}
