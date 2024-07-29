{{-- Blog Header --}}
<h3 class="black mb-3">{{ translate('Blog') }}</h3>
<input type="hidden" name="option_name" value="blog">

{{-- Blog style Switch Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-5 mb-3">
        <label class="font-16 bold black">{{ translate('Custom Blog Style') }}
        </label>
        <span class="d-block">{{ translate('Switch on for custom blog style.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="custom_blog" value="0">
            <input type="checkbox"
                {{ isset($option_settings['custom_blog']) && $option_settings['custom_blog'] == 1 ? 'checked' : '' }}
                name="custom_blog" id="custom_blog" value="1">
            <span class="control" id="custom_blog_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>
{{-- Blog style Switch End --}}

{{-- Custom Blog Style Switch On Field Start --}}
<div id="custom_blog_switch_on_field">
    {{-- Blog Layout Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Layout') }}
            </label>
            <span
                class="d-block">{{ translate('Choose blog layout from here. If you use this option then you will able to change three type of blog layout ( Default Right Sidebar Layour ).') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1 row" id="blog_layout_image_field">
            <div class="col-4">
                <div class="input-group">
                    <input type="radio" class="d-none"
                        {{ isset($option_settings['blog_layout']) && $option_settings['blog_layout'] == 'full_layout' ? 'checked' : '' }}
                        name="blog_layout" id="full_layout" value="full_layout">
                    <label for="full_layout">
                        <img src="{{ asset('/themes/cartlooks-theme/public/blog/images/layout/no-sideber.png') }}"
                            title="no sidebar" alt="no sidebar" class="layout_img">
                    </label>
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="radio"
                        {{ isset($option_settings['blog_layout']) && $option_settings['blog_layout'] == 'left_sidebar_layout' ? 'checked' : '' }}
                        class="d-none" name="blog_layout" id="left_sidebar_layout" value="left_sidebar_layout">
                    <label for="left_sidebar_layout">
                        <img src="{{ asset('/themes/cartlooks-theme/public/blog/images/layout/left-sideber.png') }}"
                            title="left sidebar layout" alt="left sidebar layout" class="layout_img">
                    </label>
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="radio"
                        {{ isset($option_settings['blog_layout']) && $option_settings['blog_layout'] == 'right_sidebar_layout' ? 'checked' : '' }}
                        class="d-none" name="blog_layout" id="right_sidebar_layout" value="right_sidebar_layout">
                    <label for="right_sidebar_layout">
                        <img src="{{ asset('/themes/cartlooks-theme/public/blog/images/layout/right-sideber.png') }}"
                            title="right sidebar layout" alt="right sidebar layout" class="layout_img">
                    </label>
                </div>
            </div>
        </div>
    </div>
    {{-- Blog Layout Field End --}}

    {{-- Blog Column Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog Column') }}
            </label>
            <span
                class="d-block">{{ translate('Select your blog post column from here. If you use this option then you will able to select three type of blog colum layout ( Default One Column ).') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1 row" id="blog_colum_image_field">
            <div class="col-4">
                <div class="input-group">
                    <input type="radio"
                        {{ isset($option_settings['blog_colum']) && $option_settings['blog_colum'] == 'col-lg-12 col-12' ? 'checked' : '' }}
                        class="d-none" name="blog_colum" id="col-lg-12-col-12" value="col-lg-12 col-12">
                    <label for="col-lg-12-col-12">
                        <img src="{{ asset('/themes/cartlooks-theme/public/blog/images/layout/1column.png') }}"
                            title="Blog Column 1" alt="Blog Column 1" class="layout_img">
                    </label>
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="radio"
                        {{ isset($option_settings['blog_colum']) && $option_settings['blog_colum'] == 'col-lg-6 col-6' ? 'checked' : '' }}
                        class="d-none" name="blog_colum" id="col-lg-6-col-6" value="col-lg-6 col-6">
                    <label for="col-lg-6-col-6">
                        <img src="{{ asset('/themes/cartlooks-theme/public/blog/images/layout/2column.png') }}"
                            title="Blog Column 2" alt="Blog Column 2" class="layout_img">
                    </label>
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="radio"
                        {{ isset($option_settings['blog_colum']) && $option_settings['blog_colum'] == 'col-lg-4 col-6' ? 'checked' : '' }}
                        class="d-none" name="blog_colum" id="col-lg-4-col-6" value="col-lg-4 col-6">
                    <label for="col-lg-4-col-6">
                        <img src="{{ asset('/themes/cartlooks-theme/public/blog/images/layout/3column.png') }}"
                            title="Blog Column 3" alt="Blog Column 3" class="layout_img">
                    </label>
                </div>
            </div>
        </div>
    </div>
    {{-- Blog Column Field End --}}

    {{-- Blog Read More Text Setting Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Read More Text Setting') }}
            </label>
            <span class="d-block">{{ translate('Control read more text from here.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <label class="switch success">
                <input type="hidden" name="read_more_text_setting" value="default">
                <input type="checkbox"
                    {{ isset($option_settings['read_more_text_setting']) && $option_settings['read_more_text_setting'] == 'custom' ? 'checked' : '' }}
                    name="read_more_text_setting" id="read_more_text_setting" value="custom">
                <span class="control" id="read_more_text_setting_switch">
                    <span class="switch-off">Default</span>
                    <span class="switch-on">Custom</span>
                </span>
            </label>
        </div>
    </div>
    {{-- Blog Read More Text Setting Field End --}}

    {{-- Blog Read More Text Setting Switch On Field Start --}}
    <div class="form-group row py-4 border-bottom" id="read_more_text_setting_switch_on_field">
        <div class="col-xl-5 mb-3">
            <label for="read_more_text_setting" class="font-16 bold black">{{ translate('Read More Text') }}
            </label>
            <span
                class="d-block">{{ translate('Set read moer text here. If you use this option then you will able to set your won text.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <input type="text" name="read_more_text" id="read_more_text" class="form-control"
                placeholder="{{ translate('Read More Text') }}"
                value="{{ isset($option_settings['read_more_text']) ? $option_settings['read_more_text'] : '' }}">
        </div>
    </div>
    {{-- Blog Read More Text Setting Switch On Field End --}}

    {{-- Blog PerPage Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog PerPage Number') }}
            </label>
            <span
                class="d-block">{{ translate('Control the number blogs to show on each page ( Default show 9 ).') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row align-items-center">
                <input type="number" class="form-control col-3" name="blog_perpage" id="blog_perpage"
                    value="{{ isset($option_settings['blog_perpage']) ? $option_settings['blog_perpage'] : '0' }}">
                <input type="range" class="col-5 ml-2" id="blog_perpage_range" style="height: 30%;" min="0"
                    max="100"
                    value="{{ isset($option_settings['blog_perpage']) ? $option_settings['blog_perpage'] : '0' }}">
            </div>
        </div>
    </div>
    {{-- Blog PerPage Field End --}}


    {{-- Blog Pagination Position Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog Pagination Position') }}
            </label>
            <span class="d-block">{{ translate('Set blog pagination Position.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-light sm">
                    <input type="radio"
                        {{ isset($option_settings['blog_pagination_position']) && $option_settings['blog_pagination_position'] == 'left' ? 'checked' : '' }}
                        class="d-none" name="blog_pagination_position" id="left" value="left">
                    {{ translate('left') }}
                </label>
                <label class="btn btn-light sm">
                    <input type="radio"
                        {{ isset($option_settings['blog_pagination_position']) && $option_settings['blog_pagination_position'] == 'center' ? 'checked' : '' }}
                        class="d-none" name="blog_pagination_position" id="center" value="center">
                    {{ translate('center') }}
                </label>
                <label class="btn btn-light sm">
                    <input type="radio"
                        {{ isset($option_settings['blog_pagination_position']) && $option_settings['blog_pagination_position'] == 'right' ? 'checked' : '' }}
                        class="d-none" name="blog_pagination_position" id="right" value="right">
                    {{ translate('right') }}
                </label>
            </div>
        </div>
    </div>
    {{-- Blog Pagination Position Field End --}}

    {{-- Blog Pagination Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog Pagination Color') }}
            </label>
            <span class="d-block">{{ translate('Set Blog Pagination Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="blog_pagination_color"
                        value="{{ isset($option_settings['blog_pagination_color']) ? $option_settings['blog_pagination_color'] : '' }}">

                    <input type="color" class="" id="blog_pagination_color"
                        value="{{ isset($option_settings['blog_pagination_color']) ? $option_settings['blog_pagination_color'] : '#fafafa' }}">
                    <label for="blog_pagination_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="blog_pagination_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['blog_pagination_color_transparent']) && $option_settings['blog_pagination_color_transparent'] == 1 ? 'checked' : '' }}
                            name="blog_pagination_color_transparent" id="blog_pagination_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="blog_pagination_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Blog Pagination Color Field End --}}

    {{-- Blog Pagination Bg Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog Pagination Background Color') }}
            </label>
            <span class="d-block">{{ translate('Set Blog Pagination Background Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="blog_pagination_bg_color"
                        value="{{ isset($option_settings['blog_pagination_bg_color']) ? $option_settings['blog_pagination_bg_color'] : '' }}">

                    <input type="color" class="" id="blog_pagination_bg_color"
                        value="{{ isset($option_settings['blog_pagination_bg_color']) ? $option_settings['blog_pagination_bg_color'] : '#fafafa' }}">
                    <label for="blog_pagination_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="blog_pagination_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['blog_pagination_bg_color_transparent']) && $option_settings['blog_pagination_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="blog_pagination_bg_color_transparent" id="blog_pagination_bg_color_transparent"
                            value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="blog_pagination_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Blog Pagination Bg Color Field End --}}

    {{-- Blog Pagination Border Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog Pagination Border Color') }}
            </label>
            <span class="d-block">{{ translate('Set Blog Pagination Border Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="blog_pagination_border_color"
                        value="{{ isset($option_settings['blog_pagination_border_color']) ? $option_settings['blog_pagination_border_color'] : '' }}">

                    <input type="color" class="" id="blog_pagination_border_color"
                        value="{{ isset($option_settings['blog_pagination_border_color']) ? $option_settings['blog_pagination_border_color'] : '#fafafa' }}">
                    <label for="blog_pagination_border_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="blog_pagination_border_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['blog_pagination_border_color_transparent']) && $option_settings['blog_pagination_border_color_transparent'] == 1 ? 'checked' : '' }}
                            name="blog_pagination_border_color_transparent"
                            id="blog_pagination_border_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="blog_pagination_border_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Blog Pagination Border Color Field End --}}

    {{-- Blog Pagination Active Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog Pagination Active Color') }}
            </label>
            <span class="d-block">{{ translate('Set Blog Pagination Active Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="blog_pagination_active_color"
                        value="{{ isset($option_settings['blog_pagination_active_color']) ? $option_settings['blog_pagination_active_color'] : '' }}">

                    <input type="color" class="" id="blog_pagination_active_color"
                        value="{{ isset($option_settings['blog_pagination_active_color']) ? $option_settings['blog_pagination_active_color'] : '#fafafa' }}">
                    <label for="blog_pagination_active_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="blog_pagination_active_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['blog_pagination_active_color_transparent']) && $option_settings['blog_pagination_active_color_transparent'] == 1 ? 'checked' : '' }}
                            name="blog_pagination_active_color_transparent"
                            id="blog_pagination_active_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="blog_pagination_active_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Blog Pagination Active Color Field End --}}

    {{-- Blog Pagination Active Bg Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog Pagination Active Background Color') }}
            </label>
            <span class="d-block">{{ translate('Set Blog Pagination Active Background Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="blog_pagination_active_bg_color"
                        value="{{ isset($option_settings['blog_pagination_active_bg_color']) ? $option_settings['blog_pagination_active_bg_color'] : '' }}">

                    <input type="color" class="" id="blog_pagination_active_bg_color"
                        value="{{ isset($option_settings['blog_pagination_active_bg_color']) ? $option_settings['blog_pagination_active_bg_color'] : '#fafafa' }}">
                    <label for="blog_pagination_active_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="blog_pagination_active_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['blog_pagination_active_bg_color_transparent']) && $option_settings['blog_pagination_active_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="blog_pagination_active_bg_color_transparent"
                            id="blog_pagination_active_bg_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="blog_pagination_active_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Blog Pagination Active Bg Color Field End --}}

    {{-- Blog Pagination Active Border Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog Pagination Active Border Color') }}
            </label>
            <span class="d-block">{{ translate('Set Blog Pagination Active Border Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="blog_pagination_active_border_color"
                        value="{{ isset($option_settings['blog_pagination_active_border_color']) ? $option_settings['blog_pagination_active_border_color'] : '' }}">

                    <input type="color" class="" id="blog_pagination_active_border_color"
                        value="{{ isset($option_settings['blog_pagination_active_border_color']) ? $option_settings['blog_pagination_active_border_color'] : '#fafafa' }}">
                    <label for="blog_pagination_active_border_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="blog_pagination_active_border_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['blog_pagination_active_border_color_transparent']) && $option_settings['blog_pagination_active_border_color_transparent'] == 1 ? 'checked' : '' }}
                            name="blog_pagination_active_border_color_transparent"
                            id="blog_pagination_active_border_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="blog_pagination_active_border_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Blog Pagination Active Border Color Field End --}}

    {{-- Blog Pagination Hover Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog Pagination Hover Color') }}
            </label>
            <span class="d-block">{{ translate('Set Blog Pagination Hover Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="blog_pagination_hover_color"
                        value="{{ isset($option_settings['blog_pagination_hover_color']) ? $option_settings['blog_pagination_hover_color'] : '' }}">

                    <input type="color" class="" id="blog_pagination_hover_color"
                        value="{{ isset($option_settings['blog_pagination_hover_color']) ? $option_settings['blog_pagination_hover_color'] : '#fafafa' }}">
                    <label for="blog_pagination_hover_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="blog_pagination_hover_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['blog_pagination_hover_color_transparent']) && $option_settings['blog_pagination_hover_color_transparent'] == 1 ? 'checked' : '' }}
                            name="blog_pagination_hover_color_transparent"
                            id="blog_pagination_hover_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="blog_pagination_hover_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Blog Pagination Hover Color Field End --}}

    {{-- Blog Pagination Hover Bg Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog Pagination Hover Background Color') }}
            </label>
            <span class="d-block">{{ translate('Set Blog Pagination Hover Background Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="blog_pagination_hover_bg_color"
                        value="{{ isset($option_settings['blog_pagination_hover_bg_color']) ? $option_settings['blog_pagination_hover_bg_color'] : '' }}">

                    <input type="color" class="" id="blog_pagination_hover_bg_color"
                        value="{{ isset($option_settings['blog_pagination_hover_bg_color']) ? $option_settings['blog_pagination_hover_bg_color'] : '#fafafa' }}">
                    <label for="blog_pagination_hover_bg_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="blog_pagination_hover_bg_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['blog_pagination_hover_bg_color_transparent']) && $option_settings['blog_pagination_hover_bg_color_transparent'] == 1 ? 'checked' : '' }}
                            name="blog_pagination_hover_bg_color_transparent"
                            id="blog_pagination_hover_bg_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="blog_pagination_hover_bg_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Blog Pagination Hover Bg Color Field End --}}

    {{-- Blog Pagination Hover Border Color Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-5 mb-3">
            <label class="font-16 bold black">{{ translate('Blog Pagination Hover Border Color') }}
            </label>
            <span class="d-block">{{ translate('Set Blog Pagination Hover Border Color.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <div class="row ml-2">
                <div class="color justify-content-between">
                    <input type="text" class="form-control" name="blog_pagination_hover_border_color"
                        value="{{ isset($option_settings['blog_pagination_hover_border_color']) ? $option_settings['blog_pagination_hover_border_color'] : '' }}">

                    <input type="color" class="" id="blog_pagination_hover_border_color"
                        value="{{ isset($option_settings['blog_pagination_hover_border_color']) ? $option_settings['blog_pagination_hover_border_color'] : '#fafafa' }}">
                    <label for="blog_pagination_hover_border_color">{{ translate('Select Color') }}</label>
                </div>
                <div class="d-flex align-items-center">
                    <label class="custom-checkbox position-relative ml-2 mr-1">
                        <input type="hidden" name="blog_pagination_hover_border_color_transparent" value="0">
                        <input type="checkbox"
                            {{ isset($option_settings['blog_pagination_hover_border_color_transparent']) && $option_settings['blog_pagination_hover_border_color_transparent'] == 1 ? 'checked' : '' }}
                            name="blog_pagination_hover_border_color_transparent"
                            id="blog_pagination_hover_border_color_transparent" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="black font-16"
                        for="blog_pagination_hover_border_color_transparent">{{ translate('Transparent') }}</label>
                </div>
            </div>
        </div>
    </div>
    {{-- Blog Pagination Hover Border Color Field End --}}
</div>
{{-- Custom Blog Style Switch On Field End --}}
