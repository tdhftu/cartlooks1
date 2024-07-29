<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Plugin\CartLooksCore\Models\States;
use Plugin\CartLooksCore\Models\CitiesTranslation;

class Cities extends Model
{

    protected $table = "tl_com_cities";

    public function translation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $city_translations = $this->city_translations->where('lang', $lang)->first();
        return $city_translations != null ? $city_translations->$field : $this->$field;
    }

    public function city_translations()
    {
        return $this->hasMany(CitiesTranslation::class, 'city_id');
    }

    public function state()
    {
        return $this->belongsTo(States::class, 'state_id');
    }
}
