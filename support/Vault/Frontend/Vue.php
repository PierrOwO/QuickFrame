<?php

namespace Support\Vault\Frontend;

use Carbon\Carbon;
use Support\Vault\Sanctum\Log;

class Vue
{
    static function prepareDataToSend(string $viewName, array $data = [])
{
    $baseView = config('app.vue_app_view');

    $user = auth()->user();
    $frameworkVersion = config('app.version_framework');

    $data['view'] = $data['view'] ?? $viewName;
    $data['year'] = $data['year']  ?? Carbon::now()->format('Y');
    $data['version'] = $data['version']  ?? $frameworkVersion;

    Log::debug('debug: ', $data);

    return view($baseView, $data);
}
}