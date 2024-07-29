<?php

namespace Theme\CartLooksTheme\Models;

use Illuminate\Database\Eloquent\Model;
use Theme\CartLooksTheme\Models\TlWidgetInputField;

class TlWidget extends Model
{
    protected $table = "tl_widgets";
    protected $guarded = [];

    // Widget Has many inputs
    public function widgetInputFields()
    {
        return $this->hasMany(TlWidgetInputField::class, 'widget_id')->select('id', 'field_type', 'title_text');
    }
}
