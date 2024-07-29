<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;
use Plugin\CartLooksCore\Models\Cities;

class ShippingZoneCities extends Model
{

    protected $table = "tl_com_shipping_zone_has_cities";

    protected $fillable = ['city_id', 'zone_id'];

    public function city()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }
}
