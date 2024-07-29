<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHasChoices extends Model
{

    protected $table = "tl_com_product_has_choices";

    protected $fillable = ['product_id', 'choice_id'];
}
