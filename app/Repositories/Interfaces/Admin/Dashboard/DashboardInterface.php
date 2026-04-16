<?php

namespace App\Repositories\Interfaces\Admin\Dashboard;

interface DashboardInterface
{
    public function getChartData($year);
}