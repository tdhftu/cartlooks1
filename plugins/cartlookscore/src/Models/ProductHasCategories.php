<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;
use Plugin\CartLooksCore\Models\ProductCategory;

class ProductHasCategories extends Model
{

    protected $table = "tl_com_product_has_categories";

    protected $fillable = ['product_id', 'category_id'];


    public function category_info()
    {
        $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
