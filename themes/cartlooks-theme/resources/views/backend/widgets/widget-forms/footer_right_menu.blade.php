@php
    $menu_groups = (new \Core\Repositories\MenuRepository())->getAllMenuGroups();
    $widget_title = isset($value) && isset($value['widget_title']) ? $value['widget_title'] : '';
    $menu_group_id = isset($value) && isset($value['menu_group_id']) ? $value['menu_group_id'] : null;
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
        <label for="menu_group_id">{{ translate('Select Menu Group') }}</label>
        <select class="form-control" name="menu_group_id" id="menu_group_id"
            @if (!empty($lang) && $lang != getdefaultlang()) disabled @endif>
            <option value="null">{{ translate('Select Menu Group') }}
            </option>
            @foreach ($menu_groups as $group)
                <option value="{{ $group->id }}"
                    {{ $menu_group_id != null && $menu_group_id == $group->id ? 'selected' : '' }}>{{ $group->name }}
                </option>
            @endforeach
        </select>
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
