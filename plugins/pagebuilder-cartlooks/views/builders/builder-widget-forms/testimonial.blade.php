<ul class="nav nav-tabs mb-20" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="content-info-tab" data-toggle="tab" href="#content-info" role="tab"
            aria-controls="content-info" aria-selected="true">{{ translate('Content') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="background-tab" data-toggle="tab" href="#background" role="tab"
            aria-controls="background" aria-selected="false">{{ translate('Background') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="advanced-tab" data-toggle="tab" href="#advanced" role="tab" aria-controls="button"
            aria-selected="false">{{ translate('Advanced') }}</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">

    <!-- Content Properties -->
    <div class="tab-pane fade show active" id="content-info" role="tabpanel" aria-labelledby="content-info-tab">
        <!-- Category Type -->
        <div class="form-group mb-3">
            <label for="type" class="font-14 bold black">{{ translate('Reviews Type') }}</label>
            <div class="mt-1">
                <select name="type" id="type" class="form-control">
                    <option value="latest" @selected(isset($widget_properties['type']) && $widget_properties['type'] == 'latest')>{{ translate('Latest Reviews') }}</option>
                    <option value="top" @selected(isset($widget_properties['type']) && $widget_properties['type'] == 'top')>{{ translate('Top Reviews') }}</option>
                </select>
            </div>
        </div>

        <!-- Item Count -->
        <div class="form-group mb-3">
            <label for="count" class="font-14 bold black">{{ translate('Item Count') }}</label>
            <div class="mt-1">
                <input type="number" min="1" step="1" required name="count" id="count"
                    class="form-control" placeholder="{{ translate('Item Count') }}"
                    value="{{ isset($widget_properties['count']) ? $widget_properties['count'] : '' }}">
            </div>
        </div>
    </div>


    <!-- Include background Properties -->
    @include('plugin/pagebuilder-cartlooks::page-builder.properties.background-properties', [
        'properties' => $widget_properties,
    ])

    <!-- Include Advance Properties -->
    @include('plugin/pagebuilder-cartlooks::page-builder.properties.advance-properties', [
        'properties' => $widget_properties,
    ])
</div>
