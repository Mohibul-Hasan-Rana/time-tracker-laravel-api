<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface ReportInterface
{
    public function generate(User $user, array $filters);
}
