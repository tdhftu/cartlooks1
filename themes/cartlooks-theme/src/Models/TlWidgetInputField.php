<?php

namespace Theme\CartLooksTheme\Models;

use Illuminate\Database\Eloquent\Model;
use Theme\CartLooksTheme\Models\TlWidgetInputOption;

class TlWidgetInputField extends Model
{
    protected $table = "tl_widget_input_fields";
    protected $guarded = [];
    // Widget inputs may have many options
    public function widgetInputOptions()
    {
        return $this->hasMany(TlWidgetInputOption::class, 'widget_input_id');
    }
}
