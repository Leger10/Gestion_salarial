<?php

if (! function_exists('get_logo_path')) {
    /**
     * Récupère le chemin du logo de l'application.
     *
     * @return string
     */
    function get_logo_path()
    {
        return config('app.logo_path', 'default_logo.png');
    }
}