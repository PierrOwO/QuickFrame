<?php

namespace App\Controllers;

use App\Services\DashboardService;
use Carbon\Carbon;

class DashboardController
{
    protected DashboardService $service;

    public function __construct() {
        $this->service = new DashboardService();
    }

    public function index()
    {
        return vueView('dashboard', [
            'title' => 'Dashboard',
        ]);
    }

}