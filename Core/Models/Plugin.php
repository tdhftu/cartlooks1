<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    protected $table = "tl_plugins";

    protected $fillable = ['name', 'location', 'author', 'namespace'];
}
