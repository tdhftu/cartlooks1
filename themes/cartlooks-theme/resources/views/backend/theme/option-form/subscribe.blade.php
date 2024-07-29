@php
    $pages = getPage([['tl_pages.publish_status', '=', config('settings.page_status.publish')], ['tl_pages.publish_at', '<', currentDateTime()]]);
@endphp
{{-- Subscribe Header --}}
<h3 class="black mb-3">{{ translate('Subscribe') }}</h3>
<input type="hidden" name="option_name" value="subscribe">

{{-- Mailchimp API Key Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="mailchimp_api_key" class="font-16 bold black">{{ translate('Mailchimp API Key') }}
        </label>
        <span class="d-block">{{ translate('Set mailchimp api key') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <input type="text" name="mailchimp_api_key" id="mailchimp_api_key" class="form-control"
            value="{{ isset($option_settings['mailchimp_api_key']) ? $option_settings['mailchimp_api_key'] : '' }}">
    </div>
</div>
{{-- Mailchimp API Key Field End --}}

{{-- Mailchimp List ID Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="mailchimp_list_id" class="font-16 bold black">{{ translate('Mailchimp List ID') }}
        </label>
        <span class="d-block">{{ translate('Set mailchimp list id.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <input type="text" name="mailchimp_list_id" id="mailchimp_list_id" class="form-control"
            value="{{ isset($option_settings['mailchimp_list_id']) ? $option_settings['mailchimp_list_id'] : '' }}">
    </div>
</div>
{{-- Mailchimp List ID Field End --}}

{{-- Subscription Switch Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Custom Subscripton Style') }}
        </label>
        <span class="d-block">{{ translate('Switch on for custom Subscripton style.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="custom_subscription" value="0">
            <input type="checkbox"
                {{ isset($option_settings['custom_subscription']) && $option_settings['custom_subscription'] == 1 ? 'checked' : '' }}
                name="custom_subscription" id="custom_subscription" value="1">
            <span class="control" id="custom_subscription_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>
{{-- Subscription Switch End --}}

{{-- Custom Subscription Switch On Field Start --}}
<div id="custom_subscription_switch_on_field">
    {{-- Form Button Text Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label for="subscribe_form_button_text" class="font-16 bold black">{{ translate('Form Button Text') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <input type="text" class="form-control" name="subscribe_form_button_text" id="subscribe_form_button_text"
                value="{{ isset($option_settings['subscribe_form_button_text']) ? $option_settings['subscribe_form_button_text'] : '' }}">
        </div>
    </div>
    {{-- Form Button Text Field End --}}

    {{-- Form Input Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Form Input Background Color') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="form_input_color"
                        value="{{ isset($option_settings['form_input_color']) ? $option_settings['form_input_color'] : '' }}">

                    <input type="color" class="" id="form_input_color"
                        value="{{ isset($option_settings['form_input_color']) ? $option_settings['form_input_color'] : '#fafafa' }}">
                    <label for="form_input_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="form_input_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['form_input_color_transparent']) && $option_settings['form_input_color_transparent'] == 1 ? 'checked' : '' }}
                            name="form_input_color_transparent" id="form_input_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="form_input_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Form Input Color Field End --}}

    {{-- Form Input Text Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Form Input Text Color') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="form_input_text_color"
                        value="{{ isset($option_settings['form_input_text_color']) ? $option_settings['form_input_text_color'] : '' }}">

                    <input type="color" class="" id="form_input_text_color"
                        value="{{ isset($option_settings['form_input_text_color']) ? $option_settings['form_input_text_color'] : '#fafafa' }}">
                    <label for="form_input_text_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="form_input_text_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['form_input_text_color_transparent']) && $option_settings['form_input_text_color_transparent'] == 1 ? 'checked' : '' }}
                            name="form_input_text_color_transparent" id="form_input_text_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="form_input_text_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Form Input Text Color Field End --}}

    {{-- Form Submit Button Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Form Submit Button Color') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="form_submit_button_color"
                        value="{{ isset($option_settings['form_submit_button_color']) ? $option_settings['form_submit_button_color'] : '' }}">

                    <input type="color" class="" id="form_submit_button_color"
                        value="{{ isset($option_settings['form_submit_button_color']) ? $option_settings['form_submit_button_color'] : '#fafafa' }}">
                    <label for="form_submit_button_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="form_submit_button_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['form_submit_button_color_transparent']) && $option_settings['form_submit_button_color_transparent'] == 1 ? 'checked' : '' }}
                            name="form_submit_button_color_transparent" id="form_submit_button_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="form_submit_button_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Form Submit Button Color Field End --}}

    {{-- Form Submit Button Background Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Form Submit Button Background Color') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control"name="form_submit_button_bg_color"
                        value="{{ isset($option_settings['form_submit_button_bg_color']) ? $option_settings['form_submit_button_bg_color'] : '' }}">

                    <input type="color" class="" id="form_submit_button_bg_color"
                        value="{{ isset($option_settings['form_submit_button_bg_color']) ? $option_settings['form_submit_button_bg_color'] : '#fafafa' }}">
                    <label for="form_submit_button_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="form_submit_button_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['form_submit_button_bg_color_transparent']) && $option_settings['form_submit_button_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="form_submit_button_bg_color_transparent"
                            id="form_submit_button_bg_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="form_submit_button_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Form Submit Button Background Color Field End --}}

    {{-- Form Submit Button Hover Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Form Submit Button Hover Color') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="form_submit_button_hover_color"
                        value="{{ isset($option_settings['form_submit_button_hover_color']) ? $option_settings['form_submit_button_hover_color'] : '' }}">

                    <input type="color" class="" id="form_submit_button_hover_color"
                        value="{{ isset($option_settings['form_submit_button_hover_color']) ? $option_settings['form_submit_button_hover_color'] : '#fafafa' }}">
                    <label for="form_submit_button_hover_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="form_submit_button_hover_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['form_submit_button_hover_color_transparent']) && $option_settings['form_submit_button_hover_color_transparent'] == 1 ? 'checked' : '' }}
                            name="form_submit_button_hover_color_transparent"
                            id="form_submit_button_hover_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="form_submit_button_hover_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Form Submit Button Hover Color Field End --}}

    {{-- Form Submit Button Background Hover Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Form Submit Button Hover Background Color') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control"name="form_submit_button_bg_hover_color"
                        value="{{ isset($option_settings['form_submit_button_bg_hover_color']) ? $option_settings['form_submit_button_bg_hover_color'] : '' }}">

                    <input type="color" class="" id="form_submit_button_bg_hover_color"
                        value="{{ isset($option_settings['form_submit_button_bg_hover_color']) ? $option_settings['form_submit_button_bg_hover_color'] : '#fafafa' }}">
                    <label for="form_submit_button_bg_hover_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="form_submit_button_bg_hover_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['form_submit_button_bg_hover_color_transparent']) && $option_settings['form_submit_button_bg_hover_color_transparent'] == 1 ? 'checked' : '' }}
                            name="form_submit_button_bg_hover_color_transparent"
                            id="form_submit_button_bg_hover_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="form_submit_button_bg_hover_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Form Submit Button Background Hover Color Field End --}}
</div>
{{-- Custom Subscription Switch On Field End --}}
