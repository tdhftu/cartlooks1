<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValues extends Model
{

    protected $table = "tl_com_attribute_values";

    protected $fillable = ['attribute_id'];
}
