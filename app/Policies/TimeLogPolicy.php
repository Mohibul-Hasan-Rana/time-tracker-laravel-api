<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\TimeLog;
use Illuminate\Auth\Access\Response;

class TimeLogPolicy
{
    public function create(User $user, TimeLog $timeLog)
    {
        return $user->id === $timeLog->project->client->user_id;
    }

    public function update(User $user, TimeLog $timeLog)
    {
        return $user->id === $timeLog->user_id;
    }

    public function delete(User $user, TimeLog $timeLog)
    {
        return $user->id === $timeLog->user_id;
    }
}
