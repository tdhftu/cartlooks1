<?php

namespace Plugin\Multivendor\Models;

use Core\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Plugin\CartLooksCore\Models\OrderHasProducts;
use Plugin\CartLooksCore\Models\Product;
use Plugin\CartLooksCore\Models\ProductReview;

class SellerShop extends Model
{

    protected $table = "tl_com_seller_shop";


    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'supplier', 'seller_id');
    }


    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(ProductReview::class, Product::class, 'supplier', 'product_id', 'seller_id', 'id');
    }

    public function orders()
    {
        return $this->hasManyThrough(OrderHasProducts::class, Product::class, 'supplier', 'product_id', 'seller_id', 'id');
    }

    public function followers()
    {
        return $this->hasMany(SellerFollowers::class, 'seller_id', 'seller_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
