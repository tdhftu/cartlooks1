{{-- Menu Header --}}
<h3 class="black mb-3">{{ translate('Menu') }}</h3>
<input type="hidden" name="option_name" value="menu">

{{-- Menu Switch Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3 mb-3">
        <label class="font-16 bold black">{{ translate('Custom Menu Style') }}
        </label>
        <span class="d-block">{{ translate('Switch on for custom menu style.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="custom_menu" value="0">
            <input type="checkbox"
                {{ isset($option_settings['custom_menu']) && $option_settings['custom_menu'] == 1 ? 'checked' : '' }}
                name="custom_menu" id="custom_menu" value="1">
            <span class="control" id="custom_menu_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>
{{-- Menu Switch End --}}

{{-- Custom Menu Switch on field start --}}
<div id="custom_menu_switch_on_field">
    {{-- Menu Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Menu Color') }}
            </label>
            <span class="d-block">{{ translate('Set header menu color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="menu_color"
                        value="{{ isset($option_settings['menu_color']) ? $option_settings['menu_color'] : '' }}">

                    <input type="color" class="" id="menu_color"
                        value="{{ isset($option_settings['menu_color']) ? $option_settings['menu_color'] : '#fafafa' }}">
                    <label for="menu_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="menu_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['menu_color_transparent']) && $option_settings['menu_color_transparent'] == 1 ? 'checked' : '' }}
                            name="menu_color_transparent" id="menu_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16" for="menu_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Menu Color Field End --}}

    {{-- Menu Hover Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Menu Hover Color') }}
            </label>
            <span class="d-block">{{ translate('Set header menu hover color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="menu_hover_color"
                        value="{{ isset($option_settings['menu_hover_color']) ? $option_settings['menu_hover_color'] : '' }}">

                    <input type="color" class="" id="menu_hover_color"
                        value="{{ isset($option_settings['menu_hover_color']) ? $option_settings['menu_hover_color'] : '#fafafa' }}">
                    <label for="menu_hover_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="menu_hover_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['menu_hover_color_transparent']) && $option_settings['menu_hover_color_transparent'] == 1 ? 'checked' : '' }}
                            name="menu_hover_color_transparent" id="menu_hover_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="menu_hover_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Menu Hover Color Field End --}}

    {{-- Sub Menu Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Sub Menu Color') }}
            </label>
            <span class="d-block">{{ translate('Set header sub menu color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="sub_menu_color"
                        value="{{ isset($option_settings['sub_menu_color']) ? $option_settings['sub_menu_color'] : '' }}">

                    <input type="color" class="" id="sub_menu_color"
                        value="{{ isset($option_settings['sub_menu_color']) ? $option_settings['sub_menu_color'] : '#fafafa' }}">
                    <label for="sub_menu_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="sub_menu_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['sub_menu_color_transparent']) && $option_settings['sub_menu_color_transparent'] == 1 ? 'checked' : '' }}
                            name="sub_menu_color_transparent" id="sub_menu_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="sub_menu_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Sub Menu Color Field End --}}

    {{-- Sub Menu Hover Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4 mb-3">
            <label class="font-16 bold black">{{ translate('Sub Menu Hover Color') }}
            </label>
            <span class="d-block">{{ translate('Set header sub menu hover color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="sub_menu_hover_color"
                        value="{{ isset($option_settings['sub_menu_hover_color']) ? $option_settings['sub_menu_hover_color'] : '' }}">

                    <input type="color" class="" id="sub_menu_hover_color"
                        value="{{ isset($option_settings['sub_menu_hover_color']) ? $option_settings['sub_menu_hover_color'] : '#fafafa' }}">
                    <label for="sub_menu_hover_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="sub_menu_hover_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['sub_menu_hover_color_transparent']) && $option_settings['sub_menu_hover_color_transparent'] == 1 ? 'checked' : '' }}
                            name="sub_menu_hover_color_transparent" id="sub_menu_hover_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="sub_menu_hover_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Sub Menu Hover Color Field End --}}
</div>
{{-- Custom Menu Switch on field end --}}
