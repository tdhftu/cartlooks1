<h3 class="black mb-3">{{ translate('GDPR (Cookies Consent)') }}</h3>
<input type="hidden" name="option_name" value="gdpr">
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Enable Cookie Consent') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="gdpr_status" value="0">
            <input type="checkbox"
                {{ isset($option_settings['gdpr_status']) && $option_settings['gdpr_status'] == 1 ? 'checked' : '' }}
                name="gdpr_status" id="gdpr_status" value="1">
            <span class="control" id="gdpr_status_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>


<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="gdpr_btn_label" class="font-16 bold black">{{ translate('Button Label') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <input type="text" class="form-control" name="gdpr_btn_label" id="gdpr_btn_label"
            value="{{ isset($option_settings['gdpr_btn_label']) ? $option_settings['gdpr_btn_label'] : '' }}"
            placeholder="{{ translate('Enter button Label') }}">
    </div>
</div>

<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="gdpr_message" class="font-16 bold black">{{ translate('Message') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <textarea class="form-control text-editor" name="gdpr_message" id="gdpr_message"> {{ isset($option_settings['gdpr_message']) ? $option_settings['gdpr_message'] : '' }}</textarea>
    </div>
</div>

<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="gdpr_position_class" class="font-16 bold black">{{ translate('Position') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <select class="form-control" name="gdpr_position_class" id="gdpr_position_class">
            <option value="right" @selected(isset($option_settings['gdpr_position_class']) && $option_settings['gdpr_position_class'] == 'right')>Bottom Right</option>
            <option value="left" @selected(isset($option_settings['gdpr_position_class']) && $option_settings['gdpr_position_class'] == 'left')>Bottom Left</option>
        </select>
    </div>
</div>
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Background Color') }}</label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="gdpr_bg_color"
                    value="{{ isset($option_settings['gdpr_bg_color']) ? $option_settings['gdpr_bg_color'] : '' }}">

                <input type="color" class="" id="gdpr_bg_color"
                    value="{{ isset($option_settings['gdpr_bg_color']) ? $option_settings['gdpr_bg_color'] : '#fafafa' }}">

                <label for="gdpr_bg_color">{{ translate('Select Color') }}</label>
            </div>
        </div>
    </div>
</div>
