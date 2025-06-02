<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Project;
use App\Models\TimeLog;
use App\Policies\ClientPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\TimeLogPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        Client::class => ClientPolicy::class,
        Project::class => ProjectPolicy::class,
        TimeLog::class => TimeLogPolicy::class,
    ];

    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    
}
