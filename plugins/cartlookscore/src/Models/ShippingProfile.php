<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;
use Plugin\CartLooksCore\Models\ShippingZone;
use Plugin\CartLooksCore\Models\ShippingProfileProducts;

class ShippingProfile extends Model
{
    protected $table = "tl_com_shipping_profiles";

    public function products()
    {
        return $this->hasMany(ShippingProfileProducts::class, 'profile_id');
    }

    public function zones()
    {
        return $this->hasMany(ShippingZone::class, 'profile_id');
    }
}
