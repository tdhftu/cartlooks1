{{-- 404 Page Header --}}
<h3 class="black mb-3">{{ translate('404 Page') }}</h3>
<input type="hidden" name="option_name" value="page_404">

{{-- 404 image Switch Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Custom 404 Style') }}
        </label>
        <span class="d-block">{{ translate('Switch on for custom 404 style.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="custom_404" value="0">
            <input type="checkbox"
                {{ isset($option_settings['custom_404']) && $option_settings['custom_404'] == 1 ? 'checked' : '' }}
                name="custom_404" id="custom_404" value="1">
            <span class="control" id="custom_404_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>
{{-- Header Logo Switch End --}}

{{-- Custom 404 Page Switch On Field Start --}}
<div id="custom_404_switch_on_field">
    {{-- 404 Page Subtittle Field Start --}}
    <div class="form-group row py-3 border-bottom">
        <div class="col-xl-4">
            <label for="page_404_title" class="font-16 bold black">{{ translate('Page Title') }}
            </label>
            <span class="d-block">{{ translate('Set Page Title') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <input type="text" name="page_404_title" id="page_404_title" class="form-control"
                value="{{ isset($option_settings['page_404_title']) ? $option_settings['page_404_title'] : '' }}"
                placeholder="{{ translate('Page Title') }}">
        </div>
    </div>
    {{-- 404 Page Subtittle Field End --}}

    {{-- 404 Image Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label for="404_image" class="font-16 bold black">{{ translate('404 Image') }}
            </label>
            <span
                class="d-block">{{ translate('Upload your site 404_image for header ( recommendation png format ).') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            @include('core::base.includes.media.media_input', [
                'input' => '404_image',
                'data' => isset($option_settings['404_image']) ? $option_settings['404_image'] : null,
            ])
        </div>
    </div>
    {{-- 404 Image Field End --}}

    {{-- Button Text Field Start --}}
    <div class="form-group row py-3 border-bottom">
        <div class="col-xl-4">
            <label for="page_404_button_text" class="font-16 bold black">{{ translate('Button Text') }}
            </label>
            <span class="d-block">{{ translate('Button Text') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <input type="text" name="page_404_button_text" id="page_404_button_text" class="form-control"
                value="{{ isset($option_settings['page_404_button_text']) ? $option_settings['page_404_button_text'] : '' }}"
                placeholder="{{ translate('Button Text') }}">
        </div>
    </div>
    {{-- Button Text Field End --}}

    {{-- Button Background color --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Button Background Color') }}
            </label>
            <span class="d-block">{{ translate('Button Background Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="button_bg_color"
                        value="{{ isset($option_settings['button_bg_color']) ? $option_settings['button_bg_color'] : '' }}">

                    <input type="color" class="" id="button_bg_color"
                        value="{{ isset($option_settings['button_bg_color']) ? $option_settings['button_bg_color'] : '#fafafa' }}">

                    <label for="button_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="button_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['button_bg_color_transparent']) && $option_settings['button_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="button_bg_color_transparent" id="button_bg_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="button_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Button Background Color Field End --}}

    {{-- Button Text color --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Button Text Color') }}
            </label>
            <span class="d-block">{{ translate('Button Text Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="button_text_color"
                        value="{{ isset($option_settings['button_text_color']) ? $option_settings['button_text_color'] : '' }}">

                    <input type="color" class="" id="button_text_color"
                        value="{{ isset($option_settings['button_text_color']) ? $option_settings['button_text_color'] : '#fafafa' }}">

                    <label for="button_text_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="button_text_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['button_text_color_transparent']) && $option_settings['button_text_color_transparent'] == 1 ? 'checked' : '' }}
                            name="button_text_color_transparent" id="button_text_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="button_text_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Button text Color Field End --}}

    {{-- Button Hover Background color --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Button Hover Background Color') }}
            </label>
            <span class="d-block">{{ translate('Button Hover Background Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="button_hover_bg_color"
                        value="{{ isset($option_settings['button_hover_bg_color']) ? $option_settings['button_hover_bg_color'] : '' }}">

                    <input type="color" class="" id="button_hover_bg_color"
                        value="{{ isset($option_settings['button_hover_bg_color']) ? $option_settings['button_hover_bg_color'] : '#fafafa' }}">

                    <label for="button_hover_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="button_hover_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['button_hover_bg_color_transparent']) && $option_settings['button_hover_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="button_hover_bg_color_transparent" id="button_hover_bg_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="button_hover_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Button Hover Background Color Field End --}}

    {{-- Button Hover Text color --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Button Hover Text Color') }}
            </label>
            <span class="d-block">{{ translate('Button Hover Text Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="button_hover_text_color"
                        value="{{ isset($option_settings['button_hover_text_color']) ? $option_settings['button_hover_text_color'] : '' }}">

                    <input type="color" class="" id="button_hover_text_color"
                        value="{{ isset($option_settings['button_hover_text_color']) ? $option_settings['button_hover_text_color'] : '#fafafa' }}">

                    <label for="button_hover_text_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="button_hover_text_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['button_hover_text_color_transparent']) && $option_settings['button_hover_text_color_transparent'] == 1 ? 'checked' : '' }}
                            name="button_hover_text_color_transparent" id="button_hover_text_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="button_hover_text_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Button hover txt Color Field End --}}
</div>
{{-- Custom 404 Page Switch On Field End --}}
