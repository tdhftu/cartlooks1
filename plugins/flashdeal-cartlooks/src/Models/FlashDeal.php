<?php

namespace Plugin\Flashdeal\Models;


use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Plugin\CartLooksCore\Models\Product;
use Plugin\Flashdeal\Models\FlashDealProducts;

class FlashDeal extends Model
{

    protected $table = "tl_com_flash_deal";

    public function translation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $deal_translations = $this->deal_translations->where('lang', $lang)->first();
        return $deal_translations != null ? $deal_translations->$field : $this->$field;
    }

    public function deal_translations()
    {
        return $this->hasMany(DealTranslation::class, 'deal_id');
    }

    public function deal_products()
    {
        return $this->hasMany(FlashDealProducts::class, 'deal_id')->orderBy('id', 'DESC');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, FlashDealProducts::class, 'deal_id', 'id', 'id', 'product_id');
    }
}
