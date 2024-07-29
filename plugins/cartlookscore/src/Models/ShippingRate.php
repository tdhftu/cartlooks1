<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;
use Plugin\CartLooksCore\Models\ShippingTimes;

class ShippingRate extends Model
{
    protected $table = "tl_com_shipping_zone_has_rates";

    public function carrier()
    {
        if (isActivePlugin('carrier-cartlooks')) {
            return $this->belongsTo(\Plugin\Carrier\Models\ShippingCarrier::class, 'carrier_id');
        } else {
            return NULL;
        }
    }

    public function shipping_time()
    {
        return $this->belongsTo(ShippingTimes::class, 'delivery_time');
    }

    public function shippied_by()
    {
        $medium = $this->shipping_medium;
        if ($medium == config('cartlookscore.shipped_by.by_air')) {
            return translate('Air Freight');
        } elseif ($medium == config('cartlookscore.shipped_by.by_ship')) {
            return translate('Ocean Freight');
        } elseif ($medium == config('cartlookscore.shipped_by.by_rail')) {
            return translate('Rail Freight');
        } elseif ($medium == config('cartlookscore.shipped_by.by_train')) {
            return translate('Road Freight');
        } else {
            return NULL;
        }
    }

    public function shipping_zone()
    {
        return $this->belongsTo(ShippingZone::class, 'zone_id', 'id');
    }
}
