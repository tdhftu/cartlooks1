@php
    $widget_title = isset($value) && isset($value['widget_title']) ? $value['widget_title'] : '';
    $access_token = isset($value) && isset($value['access_token']) ? $value['access_token'] : '';
    $image_to_show = isset($value) && isset($value['image_to_show']) ? $value['image_to_show'] : '';
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

    <div class="form-group @if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
        <label for="access_token" class="">{{ translate('Access Token') }}</label>
        <input type="text" class="form-control" id="access_token" name="access_token"
            placeholder="{{ translate('Access Token') }}" value="{{ $access_token }}"
            @if (!empty($lang) && $lang != getdefaultlang()) disabled @endif>
    </div>

    <div class="form-group @if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
        <label for="image_to_show">{{ translate('Image to show') }}</label>
        <input type="number" class="form-control" id="image_to_show" name="image_to_show"
            placeholder="{{ translate('Image to show') }}" value="{{ $image_to_show }}"
            @if (!empty($lang) && $lang != getdefaultlang()) disabled @endif>
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
