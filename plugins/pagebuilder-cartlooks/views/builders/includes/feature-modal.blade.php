<input type="hidden" name="key" value="{{ $key }}" id="feature_key">
<input type="hidden" name="lang" value="{{ $lang }}" id="lang">
<div class="form-group mb-2">
    <label for="title" class="black">{{ translate('Feature Title') }}</label>
    <input type="text" name="title" id="title" class="form-control" placeholder="{{ translate('Title') }}"
        value="{{ isset($details['title']) ? $details['title'] : '' }}">
    <span class="text-danger font-14 title-feedback d-none">{{ translate('Please choose a Title.') }}</span>
</div>
<div class="form-group mb-2">
    <label for="sub_title" class="black">{{ translate('Feature Sub Title') }}</label>
    <input type="text" name="sub_title" id="sub_title" class="form-control"
        placeholder="{{ translate('Sub Title') }}"
        value="{{ isset($details['sub_title']) ? $details['sub_title'] : '' }}">
    <span class="text-danger font-14 sub_title-feedback d-none">{{ translate('Please choose an Sub Title.') }}</span>
</div>

<div class="form-row mb-2">
    <div class="col-12">
        <label class="font-14 bold black">{{ translate('Image') }}</label>
        <div class="d-block">
            @include('core::base.includes.media.media_input', [
                'input' => 'image',
                'data' => isset($details['image']['id']) ? $details['image']['id'] : null,
            ])
        </div>
        <span class="text-danger font-14 image_id-feedback d-none">
            {{ translate('Please choose a  Image.') }}</span>
    </div>
</div>
