<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodConfig extends Model
{

    protected $table = "tl_com_payment_method_has_settings";

    protected $fillable = ['key_name', 'payment_method_id'];
}
