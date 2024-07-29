<?php

namespace Core\Models;

use Core\Models\TlBlog;
use Illuminate\Database\Eloquent\Model;

class TlBlogComment extends Model
{
    protected $guarded = [];

    //* Comment Belongs to a Blog
    public function blog()
    {
        return $this->belongsTo(TlBlog::class, 'blog_id')->select('name','permalink');
    }

    //* For all the child comments that are approve and scheduled date overcome
    public function childs()
    {
        return $this->hasMany($this, 'parent')->where('comment_date', '<', currentDateTime())
        ->where('status', config('settings.blog_comment_status.approve'))
        ->orderBy('id', 'ASC');
    }

    
}
