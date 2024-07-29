<?php

use Illuminate\Support\Facades\App;

if (!function_exists('getActiveThemeOptions')) {
    /**
     * get active theme's theme options
     *
     * @return String
     */
    function getActiveThemeOptions()
    {
        $theme = getActiveTheme();
        $item = 'theme/' . $theme->location . '::backend.includes.themeOptions';
        return $item;
    }
}


if (!function_exists('getActiveTheme')) {
    /**
     * get active theme
     *
     * @return Collection
     */
    function getActiveTheme()
    {
        return App::make('ThemeManager')
            ->where('is_activated', config('settings.general_status.active'))
            ->first();
    }
}
