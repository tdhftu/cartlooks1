@php
    $widget_title = isset($value) && isset($value['widget_title']) ? $value['widget_title'] : '';
    $mail = isset($value) && isset($value['mail']) ? $value['mail'] : '';
    $mobile = isset($value) && isset($value['mobile']) ? $value['mobile'] : '';
    $address = isset($value) && isset($value['address']) ? $value['address'] : '';
@endphp
<form action="#" class=" widget_input_field_form px-3 py-3 bg-white"
    onsubmit="event.preventDefault(); widgetInputFormSubmit(this);">
    {{-- Translated Language --}}
    <div class="row mb-3">
        <div class="col-12">
            <ul class="nav nav-tabs nav-fill border-light border-0">
                @php
                    $languages = getAllLanguages();
                @endphp
                @foreach ($languages as $key => $language)
                    <li class="nav-item">
                        <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-2"
                            href="javascript:void(0)"
                            onclick="getSidebarWidgetTranslationField(this,{{ $sidebar_has_widget_id }},{{ $widget_id }},'{{ $language->code }}')">
                            <img src="{{ asset('/public/web-assets/backend/img/flags/') . '/' . $language->code . '.png' }}"
                                width="20px" title="{{ $language->name }}">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <input type="hidden" name="lang" value="{{ $lang }}">
    {{-- Translated Language --}}
    <div class="form-group">
        <label for="widget_title" class="">{{ translate('Widget Title') }}</label>
        <input type="text" class="form-control" id="widget_title" name="widget_title"
            placeholder="{{ translate('Widget Title') }}" value="{{ $widget_title }}">
    </div>

    <div class="@if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
        <div class="form-group">
            <label for="mail" class="">{{ translate('Mail') }}</label>
            <input type="text" class="form-control" id="mail" name="mail"
                placeholder="{{ translate('Widget Title') }}" value="{{ $mail }}"
                @if (!empty($lang) && $lang != getdefaultlang()) disabled @endif>
        </div>

        <div class="form-group">
            <label for="mobile" class="">{{ translate('Mobile') }}</label>
            <input type="text" class="form-control" id="mobile" name="mobile"
                placeholder="{{ translate('Widget Title') }}" value="{{ $mobile }}"
                @if (!empty($lang) && $lang != getdefaultlang()) disabled @endif>
        </div>

        <div class="form-group">
            <label for="address">{{ translate('Address') }}</label>
            <textarea id="address" name="address" class="theme-input-style style--two" placeholder="{{ translate('Address') }}"
                @if (!empty($lang) && $lang != getdefaultlang()) disabled @endif>{{ $address }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label>{{ translate('Social Links: ') }}</label>
        <a href="javascript:void(0);" class="style--two"
            onclick="authorSocialLink()">{{ translate('Set Social Links From Theme Options') }}</a>
    </div>

    <div class="px-3 row justify-content-between">
        <div>
            <a href="javascript:;void(0)" class="text-danger"
                onclick="removeFromSidebar(this)">{{ translate('Delete') }}</a>
            <span class="mx-1">|</span>
            <a href="javascript:;void(0)" class="text-info"
                onclick="closeSidebarDropMenu(this)">{{ translate('Done') }}</a>
        </div>
        <button type="submit" class="btn btn-primary sm">{{ translate('Save') }}</button>
    </div>
</form>
