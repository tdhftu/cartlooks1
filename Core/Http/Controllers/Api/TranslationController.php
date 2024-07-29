<?php

namespace Core\Http\Controllers\Api;

use Core\Models\Language;
use Core\Models\ThemeTranslations;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class TranslationController extends Controller
{

    /**
     * Will return frontend theme translation
     * 
     * @param String $lang
     * @return \Illuminate\Http\JsonResponse
     */
    public function themeTranslations($lang)
    {
        Session::put('api_locale', $lang);
        $active_theme = getActiveTheme();
        $lan_details = cache::rememberForever("lang-details1-{$lang}", function () use ($lang) {
            return  Language::where('code', $lang)->first();
        });

        $data = Cache::rememberForever("frontend-translations-{$lang}", function () use ($lang, $active_theme) {
            return ThemeTranslations::where('lang', $lang)->where('theme', $active_theme->location)->pluck('lang_value', 'lang_key');
        });

        return response()->json(
            [
                'data' => $data,
                'language' => $lan_details
            ]
        );
    }
}
