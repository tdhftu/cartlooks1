<?php

namespace Core\Models;


use Core\Models\User;
use Core\Models\TlBlogComment;
use Core\Models\TlBlogTranslation;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;

class TlBlog extends Model
{
    protected $guarded = [];
 
    public function translation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $blog_translations = $this->blog_translations->where('lang', $lang)->first();
        return $blog_translations != null ? $blog_translations->$field : $this->$field;
    }

    // A Blog Has Many Translations
    public function blog_translations()
    {
        return $this->hasMany(TlBlogTranslation::class, 'blog_id');
    }

    // A Blog Belongs to One User
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    // A Blog Has Many Comments
    public function allblogComment()
    {
        return $this->hasMany(TlBlogComment::class, 'blog_id')->where('status', config('settings.blog_comment_status.approve'));
    }
    
}
