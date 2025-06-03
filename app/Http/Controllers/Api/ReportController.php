<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Http\Controllers\Controller;
use App\Services\DailyReportStrategy;
use App\Services\ClientReportStrategy;
use App\Services\DefaultReportStrategy;

class ReportController extends Controller
{
    public function __construct(private ReportService $reportService)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $filters = $request->all();

        $strategy = match ($request->type) {
            'daily' => new DailyReportStrategy(),
            'client' => new ClientReportStrategy(),
            default => new DefaultReportStrategy(),
        };

        $this->reportService->setStrategy($strategy);
        $data = $this->reportService->generate($user, $filters);

        return response()->json([
            'data' => $data['logs'] ?? $data,
            'total_hours' => $data['total_hours'] ?? $data->sum('total_hours'),
        ]);
    }
}
