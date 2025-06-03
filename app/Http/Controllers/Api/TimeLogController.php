<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Project;
use App\Models\TimeLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TimeLogRequest;
use App\Notifications\DailyHoursNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TimeLogController extends Controller
{
    use AuthorizesRequests;
    
    public function index(Request $request)
    {
        $projects = $request->user()->projects()->select('projects.id')->pluck('id');
        $timeLog = TimeLog::with(['project', 'user'])->whereIn('project_id', $projects)->get();
        return response()->json($timeLog);
    }

    public function show(TimeLog $timeLog)
    {        
        $timeLog->load(['project', 'user']);
        return response()->json($timeLog);
    }

    public function destroy(TimeLog $timeLog)
    {
        $this->authorize('delete', $timeLog);
        $timeLog->delete();
        return response()->json(['message' => 'TimeLog deleted']);
    }

    public function store(TimeLogRequest $request)
    {       

        
        $data = $request->validated();
        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            $data['hours'] = Carbon::parse($data['end_time'])->diffInHours($data['start_time']);
            
            $dailyHours = $request->user()->timeLogs()
            ->whereDate('start_time', Carbon::parse($data['start_time'])->startOfDay())
            ->sum('hours');
            if ($dailyHours >= 8) {
                $request->user()->notify(new DailyHoursNotification($dailyHours));
            }
        }
        $timeLog = new TimeLog($data);
        $this->authorize('create', $timeLog);
        $timeLog = $request->user()->timeLogs()->create($data);

        

        return response()->json($timeLog, 201);
    }

    public function update(TimeLogRequest $request, TimeLog $timeLog)
    {
       
        $this->authorize('update', $timeLog);
        
        
        $data = $request->validated();
       
        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            $start = Carbon::parse($data['start_time']);
            $end = Carbon::parse($data['end_time']);

            
            $data['hours'] = round($start->diffInMinutes($end, false) / 60, 2);

            
            if ($data['hours'] < 0) {
                return response()->json([
                    'message' => 'End time must be after start time.'
                ], 422);
            }

            $dailyHours = $request->user()->timeLogs()
            ->whereDate('start_time', $start->toDateString())
            ->sum('hours');
            if ($dailyHours >= 8) {
                $request->user()->notify(new DailyHoursNotification($dailyHours));
            }
        }
        
        $timeLog->update($data);

        

        return response()->json($timeLog);
    }

    public function start(TimeLogRequest $request)
    {       
        $this->authorize('create', Project::class);
        $activeLog = $request->user()->timeLogs()
            ->whereNull('end_time')
            ->first();
            
        if ($activeLog) {
            return response()->json([
                'message' => 'You already have an active time log',
            ], 400);
        }
        $data = $request->validated();
        $data['start_time'] = Carbon::now();
        $timeLog = $request->user()->timeLogs()->create($data);        

        return response()->json($timeLog, 201);
    }

    public function stop(Request $request, TimeLog $timeLog)
    {
        $this->authorize('update', $timeLog);
        if ($timeLog->end_time) {
            return response()->json([
                'message' => 'This time log is already stopped',
            ], 400);
        }
        $now = Carbon::now();
        $timeLog->update([
            'end_time' => $now,
            'hours' => round($timeLog->start_time->diffInMinutes($now) / 60, 2),
        ]);

        $dailyHours = $request->user()->timeLogs()
            ->whereDate('start_time', $now->toDateString())
            ->sum('hours');
        if ($dailyHours >= 8) {
            $request->user()->notify(new DailyHoursNotification($dailyHours));
        }

        return response()->json($timeLog);
    }

}
