@php
    $socials = null;
    if (isset($option_settings['social_field']) && $option_settings['social_field'] != '') {
        $socials = json_decode($option_settings['social_field']);
    }
@endphp
{{-- Social Header --}}
<h3 class="black mb-3">{{ translate('Social') }}</h3>
<input type="hidden" name="option_name" value="social">

{{-- Social Profile Links Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="_text" class="font-16 bold black">{{ translate('Social Profile Links') }}
        </label>
        <span class="d-block">{{ translate('Add social icon and url.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div id="socialAccordion">
            {{-- if Social is not empty a default slide will be here --}}
            @if (isset($socials))
                @foreach ($socials as $social)
                    <div class="accordion-item my-2">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button  bg-transparent">
                                {{ $social->social_icon_title == '' ? translate('New Social Link') : $social->social_icon_title }}
                            </button>
                        </h2>
                        <div class="accordion-body row">
                            <div class="col-xl-12">
                                <input type="text" name="social_icon_title[]" class="form-control icon_title my-3"
                                    placeholder="{{ translate('Title') }}" value="{{ $social->social_icon_title }}">

                                <input type="text" name="social_icon[]" class="form-control icon-picker my-3"
                                    placeholder="{{ translate('Icon(example: fa fa-facebook)') }}"
                                    value="{{ $social->social_icon }}">

                                <input type="text" name="social_icon_url[]" class="form-control my-3"
                                    placeholder="{{ translate('Url') }}" value="{{ $social->social_icon_url }}">
                            </div>
                            <div class="col-xl-12 offset-xl-10">
                                <button type="button"
                                    class="btn btn-danger accordion-delete sm">{{ translate('Delete') }}</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="accordion-item my-2">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button  bg-transparent">
                            {{ translate('New Social Link') }}
                        </button>
                    </h2>
                    <div class="accordion-body row">
                        <div class="col-xl-12">
                            <input type="text" name="social_icon_title[]" class="form-control icon_title my-3"
                                placeholder="{{ translate('Title') }}">

                            <input type="text" name="social_icon[]" class="form-control icon-picker my-3"
                                placeholder="{{ translate('Icon(example: fa fa-facebook)') }}">

                            <input type="text" name="social_icon_url[]" class="form-control my-3"
                                placeholder="{{ translate('Url') }}">
                        </div>
                        <div class="col-xl-12 offset-xl-10">
                            <button type="button"
                                class="btn btn-danger accordion-delete sm">{{ translate('Delete') }}</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row justify-content-end mr-2 mt-4">
            <button type="button" id="addSlide" class="btn btn-dark sm">{{ translate('Add Social Link') }}</button>
        </div>
    </div>
</div>
{{-- Social Profile Links Field Start --}}

{{-- Custom Social Style Switch Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Custom Social Style') }}
        </label>
        <span class="d-block">{{ translate('set custom social style.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="custom_social" value="0">
            <input type="checkbox"
                {{ isset($option_settings['custom_social']) && $option_settings['custom_social'] == 1 ? 'checked' : '' }}
                name="custom_social" id="custom_social" value="1">
            <span class="control" id="custom_social_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>
{{-- Custom Social Style Switch End --}}

{{-- custom Social Switch On Field Start --}}
<div id="custom_social_switch_on_field">
    {{--  Social Background Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate(' Social Background Color') }}
            </label>
            <span class="d-block">{{ translate('Set  Social Background Color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="social_background_color"
                        value="{{ isset($option_settings['social_background_color']) ? $option_settings['social_background_color'] : '' }}">

                    <input type="color" class="" id="social_background_color"
                        value="{{ isset($option_settings['social_background_color']) ? $option_settings['social_background_color'] : '#fafafa' }}">
                    <label for="social_background_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="social_background_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['social_background_color_transparent']) && $option_settings['social_background_color_transparent'] == 1 ? 'checked' : '' }}
                            name="social_background_color_transparent" id="social_background_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="social_background_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{--  Social Background Color Field Start --}}

    {{--  Social Border Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate(' Social Border Color') }}
            </label>
            <span class="d-block">{{ translate('Set  Social Border Color') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="social_border_color"
                        value="{{ isset($option_settings['social_border_color']) ? $option_settings['social_border_color'] : '' }}">

                    <input type="color" class="" id="social_border_color"
                        value="{{ isset($option_settings['social_border_color']) ? $option_settings['social_border_color'] : '#fafafa' }}">
                    <label for="social_border_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="social_border_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['social_border_color_transparent']) && $option_settings['social_border_color_transparent'] == 1 ? 'checked' : '' }}
                            name="social_border_color_transparent" id="social_border_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="social_border_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{--  Social Border Color Field Start --}}

    {{--  Social Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate(' Social Color') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="social_color"
                        value="{{ isset($option_settings['social_color']) ? $option_settings['social_color'] : '' }}">

                    <input type="color" class="" id="social_color"
                        value="{{ isset($option_settings['social_color']) ? $option_settings['social_color'] : '#fafafa' }}">
                    <label for="social_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="social_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['social_color_transparent']) && $option_settings['social_color_transparent'] == 1 ? 'checked' : '' }}
                            name="social_color_transparent" id="social_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="social_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{--  Social Color Field End --}}

    {{--  Social Hover Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate(' Social Hover Color') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="social_hover_color"
                        value="{{ isset($option_settings['social_hover_color']) ? $option_settings['social_hover_color'] : '' }}">

                    <input type="color" class="" id="social_hover_color"
                        value="{{ isset($option_settings['social_hover_color']) ? $option_settings['social_hover_color'] : '#fafafa' }}">
                    <label for="social_hover_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="social_hover_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['social_hover_color_transparent']) && $option_settings['social_hover_color_transparent'] == 1 ? 'checked' : '' }}
                            name="social_hover_color_transparent" id="social_hover_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="social_hover_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{--  Social Hover Color Field End --}}

    {{--  Social Hover Border Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate(' Social Hover Border Color') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="social_hover_border_color"
                        value="{{ isset($option_settings['social_hover_border_color']) ? $option_settings['social_hover_border_color'] : '' }}">

                    <input type="color" class="" id="social_hover_border_color"
                        value="{{ isset($option_settings['social_hover_border_color']) ? $option_settings['social_hover_border_color'] : '#fafafa' }}">
                    <label for="social_hover_border_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="social_hover_border_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['social_hover_border_color_transparent']) && $option_settings['social_hover_border_color_transparent'] == 1 ? 'checked' : '' }}
                            name="social_hover_border_color_transparent" id="social_hover_border_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="social_hover_border_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{--  Social Hover Border Color Field End --}}

    {{--  Social Hover Text Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Social Hover Background Color') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="social_hover_background_color"
                        value="{{ isset($option_settings['social_hover_background_color']) ? $option_settings['social_hover_background_color'] : '' }}">

                    <input type="color" class="" id="social_hover_background_color"
                        value="{{ isset($option_settings['social_hover_background_color']) ? $option_settings['social_hover_background_color'] : '#fafafa' }}">
                    <label for="social_hover_background_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="social_hover_background_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['social_hover_background_color_transparent']) && $option_settings['social_hover_background_color_transparent'] == 1 ? 'checked' : '' }}
                            name="social_hover_background_color_transparent"
                            id="social_hover_background_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="social_hover_background_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{--  Social Hover Text Color Field End --}}
</div>
{{-- custom Social Switch On Field End --}}
