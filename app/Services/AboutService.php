<?php

namespace App\Services;

class AboutService
{
    public function check(string $data): array
    {   if(!$data)
    {
        return [
            'success' => false,
        ];
    }
        return [
            'success' => true,
            'data' => $data,
        ];
    }
}