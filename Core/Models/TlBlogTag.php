<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TlBlogTag extends Model
{
    protected $guarded = [];

    public function translation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $tag_translations = $this->tag_translations->where('lang', $lang)->first();
        return $tag_translations != null ? $tag_translations->$field : $this->$field;
    }

    // Tag has Many translations
    public function tag_translations()
    {
        return $this->hasMany(TlBlogTagTranslation::class, 'tag_id');
    }
    
}
