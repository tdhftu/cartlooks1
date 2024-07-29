<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;
use Plugin\CartLooksCore\Models\ProductVariationCombination;

class VariantProductPrice extends Model
{
    protected $table = "tl_com_variant_product_price";

    protected $fillable = ['product_id', 'variant'];

    public function variant_combinations()
    {
        return $this->hasMany(ProductVariationCombination::class, 'product_variation_id	');
    }
}
