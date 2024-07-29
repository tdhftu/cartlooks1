<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{

    protected $table = "tl_com_country_translations";

    protected $fillable = ['country_id', 'lang'];
}
