<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCodCountries extends Model
{
    protected $table = "tl_com_product_cod_countries";

    protected $fillable = ['product_id', 'country_id'];
}
