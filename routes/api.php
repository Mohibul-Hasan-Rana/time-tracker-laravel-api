<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TimeLogController;
use App\Http\Controllers\Api\ReportController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Clients
    Route::apiResource('clients', ClientController::class);
    
    // Projects
    Route::apiResource('projects', ProjectController::class);
    
    // Time Logs
    Route::apiResource('time-logs', TimeLogController::class);
    Route::post('/time-logs/start', [TimeLogController::class, 'start']);
    Route::put('/time-logs/{timeLog}/stop', [TimeLogController::class, 'stop']);
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
