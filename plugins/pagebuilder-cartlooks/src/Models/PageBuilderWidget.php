<?php

namespace Plugin\TlPageBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class PageBuilderWidget extends Model
{
    protected $table = 'page_builder_widgets';
    protected $guarded = [];
    public $timestamps = false;
}
