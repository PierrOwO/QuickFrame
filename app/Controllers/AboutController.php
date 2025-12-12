<?php

namespace App\Controllers;

use App\Services\AboutService;
use Carbon\Carbon;

class AboutController
{
    protected AboutService $service;

    public function __construct() {
        $this->service = new AboutService();
    }

    public function index()
    {
        return vueView('about', [
            'title' => 'About QuickFrame',
        ]);
    }
}