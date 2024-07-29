<?php

namespace Core\Views\Composer;

use Core\Models\Language;
use Illuminate\Support\Facades\Config;

class Core
{
    public $active_langs;
    public $active_lang;
    public $style_path = "light";
    public $mood = "light";

    public function __construct()
    {
        $this->active_langs = Language::select([
            'id', 'name', 'native_name', 'code', 'is_rtl', 'flag'
        ])
            ->where('status', config('settings.general_status.active'))
            ->get();

        if (session()->has('locale')) {
            $locale = session()->get('locale', Config::get('app.locale'));
        } else {
            $locale = getDefaultLang();
        }
        
        $this->active_lang = Language::select(
            [
                'id', 'name', 'native_name', 'code', 'is_rtl', 'flag'
            ]
        )
            ->where('code', $locale)
            ->first();
        
        $this->mood = session()->get('mood' , $this->mood);

        if ($this->active_lang->is_rtl == config('settings.general_status.active') && $this->mood == 'dark') {
            $this->style_path = 'rtl_dark';
        }

        if ($this->active_lang->is_rtl == config('settings.general_status.active') && $this->mood == 'light') {
            $this->style_path = 'rtl';
        }

        if ($this->active_lang->is_rtl == config('settings.general_status.in_active') && $this->mood == 'dark') {
            $this->style_path = 'dark';
        }

    }
}
