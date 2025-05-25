<?php

namespace App\Applications;

use App\Models\Configurations;

class ConfigApplications
{
    public static function getAppName()
    {
        $appName = Configurations::where('type', 'APP_NAME')->value('value');
        return $appName;
    }
}


