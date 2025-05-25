<?php

namespace App\Services;

use App\Models\Configurations;

class ConfigApplications
{
     public function getAppName(): string
    {
        $record = Configurations::where('type', 'APP_NAME')->first();

        return $record?->value ?? config('app.name', 'DigiPrint');
    }
}
