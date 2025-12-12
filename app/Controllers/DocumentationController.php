<?php

namespace App\Controllers;

use App\Services\DocumentationService;
use Carbon\Carbon;

class DocumentationController
{
    protected DocumentationService $service;

    public function __construct() {
        $this->service = new DocumentationService();
    }

    public function index()
    {
        return vueView('docs', [
            'title' => 'Documentation',
        ]);
    }

}