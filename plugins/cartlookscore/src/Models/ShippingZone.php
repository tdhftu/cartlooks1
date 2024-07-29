<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;
use Plugin\CartLooksCore\Models\ShippingZoneCities;
use Plugin\CartLooksCore\Models\ShippingZoneStates;
use Plugin\CartLooksCore\Models\ShippingZoneCountries;

class ShippingZone extends Model
{

    protected $table = "tl_com_shipping_zones";

    public function shippingProfile()
    {
        return $this->belongsTo(ShippingProfile::class, 'profile_id', 'id');
    }

    public function cities()
    {
        return $this->hasMany(ShippingZoneCities::class, 'zone_id');
    }

    public function countries()
    {
        return $this->hasMany(ShippingZoneCountries::class, 'zone_id');
    }
    public function states()
    {
        return $this->hasMany(ShippingZoneStates::class, 'zone_id');
    }

    public function rates()
    {
        return $this->hasMany(ShippingRate::class, 'zone_id');
    }
    public function own_rates()
    {
        return $this->hasMany(ShippingRate::class, 'zone_id')->where('rate_type', config('cartlookscore.shipping_rate_type.own_rate'));
    }
    public function carrier_rates()
    {
        return $this->hasMany(ShippingRate::class, 'zone_id')->where('rate_type', config('cartlookscore.shipping_rate_type.carrier_rate'));
    }
}
