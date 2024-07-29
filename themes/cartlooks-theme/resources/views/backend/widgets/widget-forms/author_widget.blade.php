@php
    $author_name = isset($value) && isset($value['author_name']) ? $value['author_name'] : '';
    $author_image = isset($value) && isset($value['author_image']) ? $value['author_image'] : null;
    $author_short_desc = isset($value) && isset($value['author_short_desc']) ? $value['author_short_desc'] : '';
@endphp
<form action="#" class="widget_input_field_form px-3 py-3 bg-white"
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
        <label for="author_name" class="">{{ translate('Author Name') }}</label>
        <input type="text" class="form-control" id="author_name" name="author_name"
            placeholder="{{ translate('Author Name') }}" value="{{ $author_name }}">
    </div>

    <div class="form-group">
        <label for="author_short_desc">{{ translate('Author Short Desc') }}</label>
        <textarea id="author_short_desc" name="author_short_desc" class="theme-input-style style--two"
            placeholder="{{ translate('Author Short Desc') }}">{{ $author_short_desc }}</textarea>
    </div>

    <div class="form-group my-3 @if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
        <label for="author_image">{{ translate('Author Image') }}</label>
        <div class="row justify-content-center mt-2">
            @include('core::base.includes.media.media_input', [
                'input' => 'author_image',
                'data' => $author_image,
                'disable' => !empty($lang) && $lang != getdefaultlang() ? true : false,
            ])
        </div>
    </div>

    <div class="pt-4 pb-2">
        <span class="black font-16">{{ translate('Add social link from ') }} <a href="javascript:void(0);"
                onclick="authorSocialLink()">{{ translate('here') }}</a></span>
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
