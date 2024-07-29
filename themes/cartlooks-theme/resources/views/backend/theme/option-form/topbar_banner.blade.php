<h3 class="black mb-3">{{ translate('Topbar Banner') }}</h3>
<input type="hidden" name="option_name" value="topbar_banner">

<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Enable Topbar Banner') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="topbar_banner_status" value="0">
            <input type="checkbox"
                {{ isset($option_settings['topbar_banner_status']) && $option_settings['topbar_banner_status'] == 1 ? 'checked' : '' }}
                name="topbar_banner_status" id="topbar_banner_status" value="1">
            <span class="control" id="topbar_banner_status_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="topbar_banner_image" class="font-16 bold black">{{ translate('Banner Image') }}
        </label>
        <span
            class="d-block">{{ translate('Upload your site topbar banner image ( recommendation png format ).') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        @include('core::base.includes.media.media_input', [
            'input' => 'topbar_banner_image',
            'data' => isset($option_settings['topbar_banner_image'])
                ? $option_settings['topbar_banner_image']
                : null,
        ])
    </div>
</div>
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="topbar_banner_link" class="font-16 bold black">{{ translate('Link') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <input type="text" class="theme-input-style" name="topbar_banner_link" id="topbar_banner_link"
            value="{{ isset($option_settings['topbar_banner_link']) ? $option_settings['topbar_banner_link'] : '' }}"
            placeholder="{{ translate('Enter Link') }}">
    </div>
</div>
