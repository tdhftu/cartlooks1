@php
    $categories = \Plugin\CartLooksCore\Models\ProductCategory::where('parent', null)
        ->where('status', config('settings.general_status.active'))
        ->orderBy('id', 'ASC')
        ->get();
    $products = Plugin\CartLooksCore\Models\Product::select('id', 'name', 'permalink')->get();
@endphp
<ul class="nav nav-tabs mb-20" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="content-info-tab" data-toggle="tab" href="#content-info" role="tab"
            aria-controls="content-info" aria-selected="true">{{ translate('Content') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="stylist-tab" data-toggle="tab" href="#stylist" role="tab" aria-controls="stylist"
            aria-selected="true">{{ translate('Style') }}</a>
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
            'widget' => 'custom_product',
        ])
        <!-- Select Option -->
        <div class="form-group mb-3">
            <label for="collection" class="font-14 bold black">{{ translate('Select Option') }}</label>
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
        <!--Section title-->
        <div class="form-group mb-3 translate-field">
            <label class="font-14 bold black">{{ translate('Section Title') }}</label>
            <div class="mt-1">
                <input type="text" class="form-control" name="section_title_t_"
                    placeholder="{{ translate('Enter Title ') }}"
                    value="{{ isset($widget_properties['section_title_t_']) ? $widget_properties['section_title_t_'] : '' }}">
            </div>
        </div>

        <!--Button title-->
        <div class="form-group mb-3 translate-field">
            <label class="font-14 bold black">{{ translate('Button Title') }}</label>
            <div class="mt-1">
                <input type="text" class="form-control" name="section_btn_title_t_"
                    placeholder="{{ translate('Enter Button Title ') }}"
                    value="{{ isset($widget_properties['section_btn_title_t_']) ? $widget_properties['section_btn_title_t_'] : '' }}">
            </div>
        </div>
        <!--Button link-->
        <div class="form-group mb-3">
            <label class="font-14 bold black">{{ translate('Button Link') }}</label>
            <div class="mt-1">
                <input type="text" class="form-control" name="button_link"
                    placeholder="{{ translate('Enter Full Link ') }}"
                    value="{{ isset($widget_properties['button_link']) ? $widget_properties['button_link'] : '' }}">
            </div>
        </div>
        <!-- Product Count -->
        <div class="form-group mb-3">
            <label for="count" class="font-14 bold black">{{ translate('Product Count') }}</label>
            <div class="mt-1">
                <input type="number" min="1" step="1" required name="count" id="count"
                    class="form-control" placeholder="{{ translate('Product Count') }}"
                    value="{{ isset($widget_properties['count']) ? $widget_properties['count'] : '' }}">
            </div>
        </div>

        <!-- Row Count -->
        <div class="form-group mb-3">
            <label for="row_count" class="font-14 bold black">{{ translate('Row Count') }}</label>
            <div class="mt-1">
                <input type="number" min="1" step="1" required name="row_count" id="row_count"
                    class="form-control" placeholder="{{ translate('Row Count') }}"
                    value="{{ isset($widget_properties['row_count']) ? $widget_properties['row_count'] : '' }}">
            </div>
        </div>

        <!-- Section Style -->
        <div class="form-group mt-2">
            <label for="style" class="mb-2 font-14 bold black">{{ translate('Section Style') }}
            </label>
            <select name="style" id="style" class="form-control">
                <option value="slider" @selected(isset($widget_properties['style']) && $widget_properties['style'] == 'slider')>{{ translate('Slider') }}</option>
                <option value="list" @selected(isset($widget_properties['style']) && $widget_properties['style'] == 'list')>{{ translate('List') }}</option>
            </select>
        </div>

        <!-- Slider Item -->
        <div
            class="form-group mt-2 slide-item {{ isset($widget_properties['style']) && $widget_properties['style'] == 'list' ? 'd-none' : '' }}">
            <label for="slide_item" class="col-5 mb-2 font-14 bold black p-0">{{ translate('Item for Single Row') }}
            </label>
            <div class="row">
                <div class="col-sm-4">
                    <select name="slide_item_lg" id="slide_item_lg" class="form-control">
                        <option value="1" @selected(isset($widget_properties['slide_item_lg']) && $widget_properties['slide_item_lg'] == '1')>1 Item</option>
                        <option value="2" @selected(isset($widget_properties['slide_item_lg']) && $widget_properties['slide_item_lg'] == '2')>2 Item</option>
                        <option value="3" @selected(isset($widget_properties['slide_item_lg']) && $widget_properties['slide_item_lg'] == '3')>3 Item</option>
                        <option value="4" @selected(isset($widget_properties['slide_item_lg']) && $widget_properties['slide_item_lg'] == '4')>4 Item</option>
                        <option value="5" @selected(isset($widget_properties['slide_item_lg']) && $widget_properties['slide_item_lg'] == '5')>5 Item</option>
                        <option value="6" @selected(isset($widget_properties['slide_item_lg']) && $widget_properties['slide_item_lg'] == '6')>6 Item</option>
                    </select>
                    <small class="bold ml-2">{{ translate('Desktop') }}</small>
                </div>

                <div class="col-sm-4">
                    <select name="slide_item_md" id="slide_item_md" class="form-control">
                        <option value="1" @selected(isset($widget_properties['slide_item_md']) && $widget_properties['slide_item_md'] == '1')>1 Item</option>
                        <option value="2" @selected(isset($widget_properties['slide_item_md']) && $widget_properties['slide_item_md'] == '2')>2 Item</option>
                        <option value="3" @selected(isset($widget_properties['slide_item_md']) && $widget_properties['slide_item_md'] == '3')>3 Item</option>
                        <option value="4" @selected(isset($widget_properties['slide_item_md']) && $widget_properties['slide_item_md'] == '4')>4 Item</option>
                        <option value="5" @selected(isset($widget_properties['slide_item_md']) && $widget_properties['slide_item_md'] == '5')>5 Item</option>
                        <option value="6" @selected(isset($widget_properties['slide_item_md']) && $widget_properties['slide_item_md'] == '6')>6 Item</option>
                    </select>
                    <small class="bold ml-2">{{ translate('Tab') }}</small>
                </div>

                <div class="col-sm-4">
                    <select name="slide_item_sm" id="slide_item_sm" class="form-control">
                        <option value="1" @selected(isset($widget_properties['slide_item_sm']) && $widget_properties['slide_item_sm'] == '1')>1 Item</option>
                        <option value="2" @selected(isset($widget_properties['slide_item_sm']) && $widget_properties['slide_item_sm'] == '2')>2 Item</option>
                        <option value="3" @selected(isset($widget_properties['slide_item_sm']) && $widget_properties['slide_item_sm'] == '3')>3 Item</option>
                        <option value="4" @selected(isset($widget_properties['slide_item_sm']) && $widget_properties['slide_item_sm'] == '4')>4 Item</option>
                        <option value="5" @selected(isset($widget_properties['slide_item_sm']) && $widget_properties['slide_item_sm'] == '5')>5 Item</option>
                        <option value="6" @selected(isset($widget_properties['slide_item_sm']) && $widget_properties['slide_item_sm'] == '6')>6 Item</option>
                    </select>
                    <small class="bold ml-2">{{ translate('Mobile') }}</small>
                </div>
            </div>
            <!-- Pagination -->
            <label for="pagination" class="ml-3 mt-3">
                <input type="checkbox" name="pagination" id="pagination" @checked(isset($widget_properties['pagination']) && $widget_properties['pagination'] == '1')
                    value="1">
                {{ translate('Show Slider Pagination') }}
            </label>
        </div>
        <!-- Product Column -->
        <div
            class="form-group mt-2 product-column {{ isset($widget_properties['style']) && $widget_properties['style'] == 'list' ? '' : 'd-none' }}">
            <label for="column" class="col-5 mb-2 font-14 bold black">{{ translate('Product Column') }}
            </label>
            <select name="column" id="column" class="col-6 form-control d-inline ml-4">
                <option value="col-12" @selected(isset($widget_properties['column']) && $widget_properties['column'] == 'col-12')>1 Column</option>
                <option value="col-6" @selected(isset($widget_properties['column']) && $widget_properties['column'] == 'col-6')>2 Column</option>
                <option value="col-sm-6 col-md-4" @selected(isset($widget_properties['column']) && $widget_properties['column'] == 'col-sm-6 col-md-4')>3 Column</option>
                <option value="col-sm-6 col-md-3" @selected(isset($widget_properties['column']) && $widget_properties['column'] == 'col-sm-6 col-md-3')>4 Column</option>
                <option value="col-sm-6 col-md-2" @selected(isset($widget_properties['column']) && $widget_properties['column'] == 'col-sm-6 col-md-2')>6 Column</option>
            </select>
        </div>

        <!-- Single Featured Item  -->
        <label for="featured_item_status" class="ml-3 mt-3">
            <input type="checkbox" name="featured_item_status" id="featured_item_status"
                @checked(isset($widget_properties['featured_item_status']) && $widget_properties['featured_item_status'] == '1') value="1">
            {{ translate('Enable Single Featured Item') }}
        </label>

        <div
            class="form-row mx-0 featured-item-option {{ isset($widget_properties['featured_item_status']) && $widget_properties['featured_item_status'] != '1' ? 'd-none' : '' }}">

            <div class="form-group mt-2  col-12">
                <label class="font-14 bold black">{{ translate('Select featured Product') }}
                </label>
                @if (count($products) > 0)
                    <select class="form-control" name="featured_product" id="select_product">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-permalink="{{ $product->permalink }}"
                                @selected(isset($widget_properties['featured_product']) && $widget_properties['featured_product'] == $product->id)>
                                {{ $product->translation('name', getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
            <!--Featured item image-->
            <div class="form-group mt-2  col-12">
                <label class="font-14 bold black">{{ translate('Featured Product Image') }}
                </label>
                @include('core::base.includes.media.media_input', [
                    'input' => 'featured_product_image',
                    'data' => isset($widget_properties['featured_product_image'])
                        ? $widget_properties['featured_product_image']
                        : null,
                ])
            </div>
            <!-- Single Featured Item Position -->
            <div class="form-group mt-2 col-12">
                <label for="featured_item_position"
                    class="font-14 bold black">{{ translate('Featured Item Position') }}
                </label>
                <select name="featured_item_position" id="featured_item_position" class="form-control">
                    <option value="start" @selected(isset($widget_properties['featured_item_position']) && $widget_properties['featured_item_position'] == 'start')>{{ translate('Start') }}</option>
                    <option value="end" @selected(isset($widget_properties['featured_item_position']) && $widget_properties['featured_item_position'] == 'end')>{{ translate('End') }}</option>
                </select>
            </div>
            <!--End Single Featured Item Position -->
        </div>
    </div>

    <!-- Style Properties -->
    <div class="tab-pane fade" id="stylist" role="tabpanel" aria-labelledby="stylist-tab">

        <!-- Title  Color -->
        <div class="form-group mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Title Color') }} </label>
            </div>
            <div class="col-sm-12">
                <div class="input-group addon">
                    <input type="text" name="title_color_c_" class="color-input form-control style--two"
                        placeholder="#000000"
                        value="{{ isset($widget_properties['title_color_c_']) ? $widget_properties['title_color_c_'] : '' }}">
                    <div class="input-group-append">
                        <input type="color" class="input-group-text theme-input-style2 color-picker"
                            value="{{ isset($widget_properties['title_color_c_']) ? $widget_properties['title_color_c_'] : '#000000' }}">
                    </div>
                </div>
            </div>
        </div>
        <!-- Button   Color -->
        <div class="form-group mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Button Color') }} </label>
            </div>
            <div class="col-sm-12">
                <div class="input-group addon">
                    <input type="text" name="btn_color_c_" class="color-input form-control style--two"
                        placeholder="#000000"
                        value="{{ isset($widget_properties['btn_color_c_']) ? $widget_properties['btn_color_c_'] : '' }}">
                    <div class="input-group-append">
                        <input type="color" class="input-group-text theme-input-style2 color-picker"
                            value="{{ isset($widget_properties['btn_color_c_']) ? $widget_properties['btn_color_c_'] : '#000000' }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Button   Color -->
        <div class="form-group mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Button Background Color') }} </label>
            </div>
            <div class="col-sm-12">
                <div class="input-group addon">
                    <input type="text" name="btn_bg_color_c_" class="color-input form-control style--two"
                        placeholder="#000000"
                        value="{{ isset($widget_properties['btn_bg_color_c_']) ? $widget_properties['btn_bg_color_c_'] : '' }}">
                    <div class="input-group-append">
                        <input type="color" class="input-group-text theme-input-style2 color-picker"
                            value="{{ isset($widget_properties['btn_bg_color_c_']) ? $widget_properties['btn_bg_color_c_'] : '#000000' }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Button  Hover Color -->
        <div class="form-group mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Button Color') }} </label>
            </div>
            <div class="col-sm-12">
                <div class="input-group addon">
                    <input type="text" name="btn_hover_color_c_" class="color-input form-control style--two"
                        placeholder="#000000"
                        value="{{ isset($widget_properties['btn_hover_color_c_']) ? $widget_properties['btn_hover_color_c_'] : '' }}">
                    <div class="input-group-append">
                        <input type="color" class="input-group-text theme-input-style2 color-picker"
                            value="{{ isset($widget_properties['btn_hover_color_c_']) ? $widget_properties['btn_hover_color_c_'] : '#000000' }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Button Hover BG  Color -->
        <div class="form-group mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Button Hover Background Color') }} </label>
            </div>
            <div class="col-sm-12">
                <div class="input-group addon">
                    <input type="text" name="btn_hover_bg_color_c_" class="color-input form-control style--two"
                        placeholder="#000000"
                        value="{{ isset($widget_properties['btn_hover_bg_color_c_']) ? $widget_properties['btn_hover_bg_color_c_'] : '' }}">
                    <div class="input-group-append">
                        <input type="color" class="input-group-text theme-input-style2 color-picker"
                            value="{{ isset($widget_properties['btn_hover_bg_color_c_']) ? $widget_properties['btn_hover_bg_color_c_'] : '#000000' }}">
                    </div>
                </div>
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

        $('#featured_item_status').on('change', function() {
            if ($('#featured_item_status').prop('checked')) {
                $('.featured-item-option').removeClass('d-none');
            } else {
                $('.featured-item-option').addClass('d-none');
            }
        });

        // Select Init
        $('#select_product').select2({
            theme: "classic"
        });

    })(jQuery)
</script>
