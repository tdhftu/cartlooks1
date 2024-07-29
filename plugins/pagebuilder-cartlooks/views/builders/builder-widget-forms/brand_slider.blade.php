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
        <!-- Brand Type -->
        <div class="form-group mb-3">
            <label for="type" class="font-14 bold black">{{ translate('Brand Type') }}</label>
            <div class="mt-1">
                <select name="type" id="type" class="form-control">
                    <option value="latest" @selected(isset($widget_properties['type']) && $widget_properties['type'] == 'latest')>{{ translate('Latest Brands') }}</option>
                    <option value="featured" @selected(isset($widget_properties['type']) && $widget_properties['type'] == 'featured')>{{ translate('Featured Brands') }}</option>
                    <option value="top" @selected(isset($widget_properties['type']) && $widget_properties['type'] == 'top')>{{ translate('Top Brands') }}</option>
                </select>
            </div>
        </div>

        <!--  Count -->
        <div class="form-group mb-3">
            <label for="count" class="font-14 bold black">{{ translate('Brand Count') }}</label>
            <div class="mt-1">
                <input type="number" min="1" step="1" required name="count" id="count"
                    class="form-control" placeholder="{{ translate('Brand Count') }}"
                    value="{{ isset($widget_properties['count']) ? $widget_properties['count'] : '' }}">
            </div>
        </div>

        <!-- Style -->
        <div class="form-group mt-2">
            <label for="style" class="col-5 mb-2 font-14 bold black">{{ translate('Display Style') }}
            </label>
            <select name="style" id="style" class="col-6 form-control d-inline ml-4">
                <option value="slider" @selected(isset($widget_properties['style']) && $widget_properties['style'] == 'slider')>{{ translate('Slider') }}</option>
                <option value="list" @selected(isset($widget_properties['style']) && $widget_properties['style'] == 'list')>{{ translate('List') }}</option>
            </select>
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
