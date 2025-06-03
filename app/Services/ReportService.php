<?php

namespace App\Services;

use App\Models\User;
use App\Interfaces\ReportInterface;

class ReportService
{
    private ReportInterface $strategy;

    public function setStrategy(ReportInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function generate(User $user, array $filters)
    {
        return $this->strategy->generate($user, $filters);
    }
}
