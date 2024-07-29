<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Plugin\CartLooksCore\Models\ProductCategoryTranslations;

class ProductCategory extends Model
{
    protected $table = "tl_com_categories";

    public function translation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $category_translations = $this->category_translations->where('lang', $lang)->first();
        return $category_translations != null ? $category_translations->$field : $this->$field;
    }

    public function category_translations()
    {
        return $this->hasMany(ProductCategoryTranslations::class, 'category_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent')->select(['id', 'name']);
    }

    public function childs()
    {
        return $this->hasMany($this, 'parent')->with(['category_translations', 'childs' => function ($q) {
            $q->with(['category_translations']);
        }])->orderBy('id', 'ASC');
    }

    public function scopeActive($query)
    {
        $query->where('status', config('settings.general_status.active'));
    }
}
