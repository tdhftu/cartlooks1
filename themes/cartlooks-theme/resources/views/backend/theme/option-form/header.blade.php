{{-- Header Option Header --}}
<h3 class="black mb-3">{{ translate('Header') }}</h3>
<input type="hidden" name="option_name" value="header">

{{-- Header Switch Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3 mb-3">
        <label class="font-16 bold black">{{ translate('Custom Header Style') }}
        </label>
        <span class="d-block">{{ translate('Switch on for custom header style.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="custom_header" value="0">
            <input type="checkbox"
                {{ isset($option_settings['custom_header']) && $option_settings['custom_header'] == 1 ? 'checked' : '' }}
                name="custom_header" id="custom_header" value="1">
            <span class="control" id="custom_header_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>
{{-- Header Switch End --}}

{{-- Custom Header Switch On Field Start --}}
<div id="custom_header_switch_on_field">

    {{-- Header Bottom Email Text --}}
    <div class="form-group row py-3 border-bottom align-items-center">
        <div class="col-xl-4 mb-3">
            <label for="header_bot_email_text"
                class="font-16 bold black">{{ translate('Header Bottom Contact Option') }}
            </label>
            <span class="d-block">{{ translate('Set Email or Phone with icon') }}</span>
        </div>
        <div class="col-xl-2 offset-xl-1">
            <input type="text" name="header_bot_email_text_icon" id="header_bot_email_text_icon"
                class="form-control icon-picker my-3 iconpicker-element iconpicker-input"
                value="{{ isset($option_settings['header_bot_email_text_icon']) ? $option_settings['header_bot_email_text_icon'] : '' }}">
        </div>
        <div class="col-xl-4">
            <input type="text" name="header_bot_email_text" id="header_bot_email_text" class="form-control"
                value="{{ isset($option_settings['header_bot_email_text']) ? $option_settings['header_bot_email_text'] : '' }}">
        </div>
    </div>
    {{-- Header Bottom Email Text --}}

    {{-- Header Top Background Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Top Background Color') }}
            </label>
            <span class="d-block">{{ translate('Set Header Top Background Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_top_bg_color"
                        value="{{ isset($option_settings['header_top_bg_color']) ? $option_settings['header_top_bg_color'] : '' }}">

                    <input type="color" class="" id="header_top_bg_color"
                        value="{{ isset($option_settings['header_top_bg_color']) ? $option_settings['header_top_bg_color'] : '#fafafa' }}">

                    <label for="header_top_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_top_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_top_bg_color_transparent']) && $option_settings['header_top_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_top_bg_color_transparent" id="header_top_bg_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_top_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Top Background Color Field End --}}

    {{-- Header Middle Background Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Middle Background Color') }}
            </label>
            <span class="d-block">{{ translate('Set Header Middle Background Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_mid_bg_color"
                        value="{{ isset($option_settings['header_mid_bg_color']) ? $option_settings['header_mid_bg_color'] : '' }}">

                    <input type="color" class="" id="header_mid_bg_color"
                        value="{{ isset($option_settings['header_mid_bg_color']) ? $option_settings['header_mid_bg_color'] : '#fafafa' }}">

                    <label for="header_mid_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_mid_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_mid_bg_color_transparent']) && $option_settings['header_mid_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_mid_bg_color_transparent" id="header_mid_bg_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_mid_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Middle Background Color Field End --}}

    {{-- Header Bottom Background Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Bottom Background Color') }}
            </label>
            <span class="d-block">{{ translate('Set Header Bottom Background Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_bot_bg_color"
                        value="{{ isset($option_settings['header_bot_bg_color']) ? $option_settings['header_bot_bg_color'] : '' }}">

                    <input type="color" class="" id="header_bot_bg_color"
                        value="{{ isset($option_settings['header_bot_bg_color']) ? $option_settings['header_bot_bg_color'] : '#fafafa' }}">

                    <label for="header_bot_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_bot_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_bot_bg_color_transparent']) && $option_settings['header_bot_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_bot_bg_color_transparent" id="header_bot_bg_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_bot_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Bottom Background Color Field End --}}

    {{-- Header Bottom Text Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Bottom Text Color') }}
            </label>
            <span class="d-block">{{ translate('Set Header Bottom Text Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_bot_text_color"
                        value="{{ isset($option_settings['header_bot_text_color']) ? $option_settings['header_bot_text_color'] : '' }}">

                    <input type="color" class="" id="header_bot_text_color"
                        value="{{ isset($option_settings['header_bot_text_color']) ? $option_settings['header_bot_text_color'] : '#fafafa' }}">

                    <label for="header_bot_text_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_bot_text_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_bot_text_color_transparent']) && $option_settings['header_bot_text_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_bot_text_color_transparent" id="header_bot_text_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_bot_text_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Bottom Text Color Field End --}}

    {{-- Sticky Header Background Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Sticky Header Background Color') }}
            </label>
            <span class="d-block">{{ translate('Set Sticky Header Background color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="sticky_header_bg_color"
                        value="{{ isset($option_settings['sticky_header_bg_color']) ? $option_settings['sticky_header_bg_color'] : '' }}">

                    <input type="color" class="" id="sticky_header_bg_color"
                        value="{{ isset($option_settings['sticky_header_bg_color']) ? $option_settings['sticky_header_bg_color'] : '#fafafa' }}">

                    <label for="sticky_header_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="sticky_header_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['sticky_header_bg_color_transparent']) && $option_settings['sticky_header_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="sticky_header_bg_color_transparent" id="sticky_header_bg_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="sticky_header_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Sticky Header Background Color Field End --}}

    {{-- Header Middle Search Button BG Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Search Form Button Color') }}
            </label>
            <span class="d-block">{{ translate('Set header search form button color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_search_form_btn_color"
                        value="{{ isset($option_settings['header_search_form_btn_color']) ? $option_settings['header_search_form_btn_color'] : '' }}">

                    <input type="color" class="" id="header_search_form_btn_color"
                        value="{{ isset($option_settings['header_search_form_btn_color']) ? $option_settings['header_search_form_btn_color'] : '#fafafa' }}">
                    <label for="header_search_form_btn_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_search_form_btn_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_search_form_btn_color_transparent']) && $option_settings['header_search_form_btn_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_search_form_btn_color_transparent"
                            id="header_search_form_btn_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_search_form_btn_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Middle Search Button BG Color End --}}

    {{-- Header Middle Search Button BG Hover Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Search Form Button Hover Color') }}
            </label>
            <span class="d-block">{{ translate('Set header search form button hover color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_search_form_btn_hover_color"
                        value="{{ isset($option_settings['header_search_form_btn_hover_color']) ? $option_settings['header_search_form_btn_hover_color'] : '' }}">

                    <input type="color" class="" id="header_search_form_btn_hover_color"
                        value="{{ isset($option_settings['header_search_form_btn_hover_color']) ? $option_settings['header_search_form_btn_hover_color'] : '#fafafa' }}">
                    <label for="header_search_form_btn_hover_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_search_form_btn_hover_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_search_form_btn_hover_color_transparent']) && $option_settings['header_search_form_btn_hover_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_search_form_btn_hover_color_transparent"
                            id="header_search_form_btn_hover_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_search_form_btn_hover_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Middle Search Button BG Hover Color Field End --}}

    {{-- Header Middle Search Button Text Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Search Form Button Text Color') }}
            </label>
            <span class="d-block">{{ translate('Set header search form button text color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_search_form_btn_text_color"
                        value="{{ isset($option_settings['header_search_form_btn_text_color']) ? $option_settings['header_search_form_btn_text_color'] : '' }}">

                    <input type="color" class="" id="header_search_form_btn_text_color"
                        value="{{ isset($option_settings['header_search_form_btn_text_color']) ? $option_settings['header_search_form_btn_text_color'] : '#fafafa' }}">
                    <label for="header_search_form_btn_text_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_search_form_btn_text_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_search_form_btn_text_color_transparent']) && $option_settings['header_search_form_btn_text_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_search_form_btn_text_color_transparent"
                            id="header_search_form_btn_text_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_search_form_btn_text_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Middle Search Button Text Color Field End --}}

    {{-- Header Middle Search Button Hover Text Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Search Form Button Hover Text Color') }}
            </label>
            <span class="d-block">{{ translate('Set header search form button hover text color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_search_form_btn_hover_text_color"
                        value="{{ isset($option_settings['header_search_form_btn_hover_text_color']) ? $option_settings['header_search_form_btn_hover_text_color'] : '' }}">

                    <input type="color" class="" id="header_search_form_btn_hover_text_color"
                        value="{{ isset($option_settings['header_search_form_btn_hover_text_color']) ? $option_settings['header_search_form_btn_hover_text_color'] : '#fafafa' }}">
                    <label for="header_search_form_btn_hover_text_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_search_form_btn_hover_text_color_transparent"
                            value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_search_form_btn_hover_text_color_transparent']) && $option_settings['header_search_form_btn_hover_text_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_search_form_btn_hover_text_color_transparent"
                            id="header_search_form_btn_hover_text_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_search_form_btn_hover_text_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Middle Search Button Hover Text Color Field End --}}

    {{-- Header Top Language Change Button Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Top Language Change Button Color') }}
            </label>
            <span class="d-block">{{ translate('Set Header Top Language Change Button color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_top_lang_btn_bg_color"
                        value="{{ isset($option_settings['header_top_lang_btn_bg_color']) ? $option_settings['header_top_lang_btn_bg_color'] : '' }}">

                    <input type="color" class="" id="header_top_lang_btn_bg_color"
                        value="{{ isset($option_settings['header_top_lang_btn_bg_color']) ? $option_settings['header_top_lang_btn_bg_color'] : '#fafafa' }}">
                    <label for="header_top_lang_btn_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_top_lang_btn_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_top_lang_btn_bg_color_transparent']) && $option_settings['header_top_lang_btn_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_top_lang_btn_bg_color_transparent"
                            id="header_top_lang_btn_bg_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_top_lang_btn_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Top Language Change Button Color Field End --}}

    {{-- Header Top Language Change Text Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Top Language Change Button Text Color') }}
            </label>
            <span class="d-block">{{ translate('Set Header Top Language Change Button Text color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_top_lang_btn_text_color"
                        value="{{ isset($option_settings['header_top_lang_btn_text_color']) ? $option_settings['header_top_lang_btn_text_color'] : '' }}">

                    <input type="color" class="" id="header_top_lang_btn_text_color"
                        value="{{ isset($option_settings['header_top_lang_btn_text_color']) ? $option_settings['header_top_lang_btn_text_color'] : '#fafafa' }}">
                    <label for="header_top_lang_btn_text_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_top_lang_btn_text_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_top_lang_btn_text_color_transparent']) && $option_settings['header_top_lang_btn_text_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_top_lang_btn_text_color_transparent"
                            id="header_top_lang_btn_text_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_top_lang_btn_text_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Middle Search Button Text Color Field End --}}

    {{-- Header Top Language Change Button Hover Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Top Language Change Button Hover Color') }}
            </label>
            <span class="d-block">{{ translate('Set Header Top Language Change Button Hover color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_top_lang_btn_hover_bg_color"
                        value="{{ isset($option_settings['header_top_lang_btn_hover_bg_color']) ? $option_settings['header_top_lang_btn_hover_bg_color'] : '' }}">

                    <input type="color" class="" id="header_top_lang_btn_hover_bg_color"
                        value="{{ isset($option_settings['header_top_lang_btn_hover_bg_color']) ? $option_settings['header_top_lang_btn_hover_bg_color'] : '#fafafa' }}">
                    <label for="header_top_lang_btn_hover_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_top_lang_btn_hover_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_top_lang_btn_hover_bg_color_transparent']) && $option_settings['header_top_lang_btn_hover_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_top_lang_btn_hover_bg_color_transparent"
                            id="header_top_lang_btn_hover_bg_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_top_lang_btn_hover_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Top Language Change Button Hover Color Field End --}}

    {{-- Header Top Language Change Hover Text Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Header Top Language Change Button Hover Text Color') }}
            </label>
            <span class="d-block">{{ translate('Set Header Top Language Change Button Hover Text color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="header_top_lang_btn_hover_text_color"
                        value="{{ isset($option_settings['header_top_lang_btn_hover_text_color']) ? $option_settings['header_top_lang_btn_hover_text_color'] : '' }}">

                    <input type="color" class="" id="header_top_lang_btn_hover_text_color"
                        value="{{ isset($option_settings['header_top_lang_btn_hover_text_color']) ? $option_settings['header_top_lang_btn_hover_text_color'] : '#fafafa' }}">
                    <label for="header_top_lang_btn_hover_text_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="header_top_lang_btn_hover_text_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['header_top_lang_btn_hover_text_color_transparent']) && $option_settings['header_top_lang_btn_hover_text_color_transparent'] == 1 ? 'checked' : '' }}
                            name="header_top_lang_btn_hover_text_color_transparent"
                            id="header_top_lang_btn_hover_text_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="header_top_lang_btn_hover_text_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Middle Search Button Hover Text Color Field End --}}



</div>
{{-- Custom Header Switch On Field End --}}
