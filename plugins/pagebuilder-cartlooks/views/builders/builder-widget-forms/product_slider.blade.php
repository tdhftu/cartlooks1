@php
    $categories = \Plugin\CartLooksCore\Models\ProductCategory::where('parent', null)
        ->where('status', config('settings.general_status.active'))
        ->orderBy('id', 'ASC')
        ->get();
@endphp
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

        @include('plugin/pagebuilder-cartlooks::page-builder.includes.lang-translate', [
            'lang' => $lang,
            'widget' => 'product_slider',
        ])
        <!-- Select Option -->
        <div class="form-group mb-3">
            <label for="collection" class="font-14 bold black">{{ translate('Select Products') }}</label>
            <div class="mt-1">
                <select class="theme-input-style custom-product-options" name="content" required>
                    <option value="new_arrival" @selected(isset($widget_properties['content']) && $widget_properties['content'] == 'new_arrival')>{{ translate('New Arrival') }}
                    </option>
                    <option value="featured" @selected(isset($widget_properties['content']) && $widget_properties['content'] == 'featured')>{{ translate('Featured Products') }}
                    </option>
                    <option value="top_selling" @selected(isset($widget_properties['content']) && $widget_properties['content'] == 'top_selling')>{{ translate('Top Selling') }}
                    </option>
                    <option value="top_reviewed" @selected(isset($widget_properties['content']) && $widget_properties['content'] == 'top_reviewed')>{{ translate('Top Reviewed') }}
                    </option>
                    <option value="category" @selected(isset($widget_properties['content']) && $widget_properties['content'] == 'category')>{{ translate('Category wise') }}</option>
                </select>
            </div>
        </div>

        <!-- Product Category -->
        <div
            class="form-row mb-20 category-options {{ isset($widget_properties['content']) && $widget_properties['content'] == 'category' ? '' : 'd-none' }}">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Select Category') }}</label>
            </div>
            <div class="col-sm-12">
                <select class="theme-input-style" name="category">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(isset($widget_properties['category']) && $widget_properties['category'] == $category->id)>{{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('category'))
                    <div class="invalid-input">{{ $errors->first('category') }}</div>
                @endif
            </div>
        </div>

        <!-- Header Title -->
        <div class="form-group mb-3 translate-field">
            <label class="font-14 bold black">{{ translate('Header Title') }}({{ translate('Optional') }})</label>
            <div class="mt-1">
                <input type="text" class="form-control" name="header_title_t_"
                    placeholder="{{ translate('Enter Title ') }}"
                    value="{{ isset($widget_properties['header_title_t_']) ? $widget_properties['header_title_t_'] : '' }}">
            </div>
        </div>

        <!-- Product Count -->
        <div class="form-group mb-3">
            <label for="count" class="font-14 bold black">{{ translate('Product Count') }}</label>
            <div class="mt-1">
                <input type="number" min="1" step="1" required name="count" class="form-control"
                    placeholder="{{ translate('Enter number of products ') }}"
                    value="{{ isset($widget_properties['count']) ? $widget_properties['count'] : '' }}">
            </div>
        </div>
        <!-- Row Count -->
        <div class="form-group mb-3">
            <label for="row_count" class="font-14 bold black">{{ translate('Row Count') }}</label>
            <div class="mt-1">
                <input type="number" min="1" step="1" required name="row_count" class="form-control"
                    placeholder="{{ translate('Enter number of row ') }}"
                    value="{{ isset($widget_properties['row_count']) ? $widget_properties['row_count'] : '' }}">
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
<script>
    (function($) {
        'use strict';

        //Category Wise Select
        $(document).on('change', '.custom-product-options', function() {
            let type = $(this).find("option:selected").val();
            if (type === 'category') {
                $('.category-options').removeClass('d-none');
            } else {
                $('.category-options').addClass('d-none');
            }
        });

        $('#style').on('change', function() {
            let option = $(this).find('option:selected').val();
            if (option == 'slider') {
                $('.slide-item').removeClass('d-none');
                $('.product-column').addClass('d-none');
            }
            if (option == 'list') {
                $('.product-column').removeClass('d-none');
                $('.slide-item').addClass('d-none');
            }
        });

    })(jQuery)
</script>
