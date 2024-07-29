@php
    $add_information = isset($value) && isset($value['add_information']) ? $value['add_information'] : '';
@endphp
<form action="#" class=" widget_input_field_form px-3 py-3 bg-white"
    onsubmit="event.preventDefault(); widgetInputFormSubmit(this);">

    <div class="form-group">
        <label for="add_information">{{ translate('Add Information') }}</label>
        <textarea id="add_information" name="add_information" class="theme-input-style style--two"
            placeholder="{{ translate('Add Information') }}">{{ $add_information }}</textarea>
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
