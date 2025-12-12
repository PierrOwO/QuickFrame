<?php

namespace App\Controllers;

use App\Services\HomeService;
use Carbon\Carbon;

class HomeController
{
    protected HomeService $service;

    public function __construct() {
        $this->service = new HomeService();
    }

    public function index()
    {
        return vueView('home', [
            'title' => 'Home page',
        ]);
    }
}