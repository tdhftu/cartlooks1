{{-- Footer Header --}}
<h3 class="black mb-3">{{ translate('Footer') }}</h3>
<input type="hidden" name="option_name" value="footer">

{{-- Footer Switch Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Custom Footer Style') }}
        </label>
        <span class="d-block">{{ translate('Switch on for custom footer style.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="custom_footer" value="0">
            <input type="checkbox"
                {{ isset($option_settings['custom_footer']) && $option_settings['custom_footer'] == 1 ? 'checked' : '' }}
                name="custom_footer" id="custom_footer" value="1">
            <span class="control" id="custom_footer_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>
{{-- Footer Switch End --}}

{{-- Custom Footer Style Switch On Field Start --}}
<div id="custom_footer_switch_on_field">
    {{-- Footer Padding Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Custom Footer Padding.') }}
            </label>
            <span class="d-block">{{ translate('Set Footer Padding.') }}</span>
        </div>
        <div class="col-xl-7 offset-xl-1 row">
            <div class="input-group my-2  col-xl-4">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="icofont-arrow-up"></i>
                    </div>
                </div>
                <input type="number" class="form-control" name="custom_footer_padding_top"
                    id="custom_footer_padding_top" placeholder="{{ translate('Top') }}"
                    value="{{ isset($option_settings['custom_footer_padding_top']) ? $option_settings['custom_footer_padding_top'] : '' }}">
            </div>

            <div class="input-group my-2  col-xl-4">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="icofont-arrow-down"></i>
                    </div>
                </div>
                <input type="number" class="form-control" name="custom_footer_padding_bottom"
                    id="custom_footer_padding_bottom" placeholder="{{ translate('Bottom') }}"
                    value="{{ isset($option_settings['custom_footer_padding_bottom']) ? $option_settings['custom_footer_padding_bottom'] : '' }}">
            </div>

            <div class="input-group my-2  col-xl-4">
                <select class="form-control select" name="custom_footer_padding_unit" id="custom_footer_padding_unit">
                    <option value="px"
                        {{ isset($option_settings['custom_footer_padding_unit']) && $option_settings['custom_footer_padding_unit'] == 'px' ? 'selected' : '' }}>
                        px</option>
                </select>
            </div>
        </div>
    </div>
    {{-- Footer Padding Field End --}}

    {{-- Footer Background Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Footer Background Color') }}
            </label>
            <span class="d-block">{{ translate('Set Background Color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="footer_background_color"
                        value="{{ isset($option_settings['footer_background_color']) ? $option_settings['footer_background_color'] : '' }}">

                    <input type="color" class="" id="footer_background_color"
                        value="{{ isset($option_settings['footer_background_color']) ? $option_settings['footer_background_color'] : '#fafafa' }}">
                    <label for="footer_background_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="footer_background_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['footer_background_color_transparent']) && $option_settings['footer_background_color_transparent'] == 1 ? 'checked' : '' }}
                            name="footer_background_color_transparent" id="footer_background_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="footer_background_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Footer Background Color Field Start --}}

    {{-- Footer Text Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Footer Text Color') }}
            </label>
            <span class="d-block">{{ translate('Set Text Color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="footer_text_color"
                        value="{{ isset($option_settings['footer_text_color']) ? $option_settings['footer_text_color'] : '' }}">

                    <input type="color" class="" id="footer_text_color"
                        value="{{ isset($option_settings['footer_text_color']) ? $option_settings['footer_text_color'] : '#fafafa' }}">
                    <label for="footer_text_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="footer_text_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['footer_text_color_transparent']) && $option_settings['footer_text_color_transparent'] == 1 ? 'checked' : '' }}
                            name="footer_text_color_transparent" id="footer_text_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="footer_text_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Footer Text Color Field Start --}}

    {{-- Footer Anchor Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Footer Anchor Color') }}
            </label>
            <span class="d-block">{{ translate('Set Footer Anchor Color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="footer_anchor_color"
                        value="{{ isset($option_settings['footer_anchor_color']) ? $option_settings['footer_anchor_color'] : '' }}">

                    <input type="color" class="" id="footer_anchor_color"
                        value="{{ isset($option_settings['footer_anchor_color']) ? $option_settings['footer_anchor_color'] : '#fafafa' }}">
                    <label for="footer_anchor_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="footer_anchor_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['footer_anchor_color_transparent']) && $option_settings['footer_anchor_color_transparent'] == 1 ? 'checked' : '' }}
                            name="footer_anchor_color_transparent" id="footer_anchor_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="footer_anchor_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Footer Anchor Color Field Start --}}

    {{-- Footer Anchor Hover Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Footer Anchor Hover Color') }}
            </label>
            <span class="d-block">{{ translate('Set Footer Anchor Hover Color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="footer_anchor_hover_color"
                        value="{{ isset($option_settings['footer_anchor_hover_color']) ? $option_settings['footer_anchor_hover_color'] : '' }}">

                    <input type="color" class="" id="footer_anchor_hover_color"
                        value="{{ isset($option_settings['footer_anchor_hover_color']) ? $option_settings['footer_anchor_hover_color'] : '#fafafa' }}">
                    <label for="footer_anchor_hover_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="footer_anchor_hover_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['footer_anchor_hover_color_transparent']) && $option_settings['footer_anchor_hover_color_transparent'] == 1 ? 'checked' : '' }}
                            name="footer_anchor_hover_color_transparent" id="footer_anchor_hover_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="footer_anchor_hover_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Footer Anchor Hover Color Field Start --}}
</div>
{{-- Custom Footer Style Switch On Field End --}}
