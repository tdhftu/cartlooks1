@extends('core::base.layouts.master')

@section('title')
    {{ translate('Page Builder') }}
@endsection

@section('custom_css')
    <!-- Jquery UI -->
    <link href="{{ asset('/public/web-assets/backend/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <!-- Summernote -->
    <link href="{{ asset('/public/web-assets/backend/plugins/summernote/summernote-lite.css') }}" rel="stylesheet" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.css') }}">

    @include('plugin/pagebuilder-cartlooks::page-builder.includes.styles')
@endsection

@section('main_content')
    <div class="row">
        <div class="col-md-8">
            <!-- Page Section List Start -->
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4><i class="icofont-building-alt mr-1"></i>{{ $data['title'] }}</h4>
                    <a href="{{ Plugin\TlPageBuilder\Helpers\BuilderHelper::$preview_url . $data['permalink'] }}"
                        target="_blank" class="btn btn-info long">{{ translate('Preview') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="section-list mx-2">
                        @foreach ($sections as $section)
                            <div class="row" id="section_{{ $section->id }}">
                                <a href="#" class="black my-auto drag-layout">
                                    <i class="icofont-drag"></i>
                                </a>
                                <div class="row my-2 mx-0 col-11 bg-white layout-height">
                                    @foreach ($section->layouts as $layout)
                                        <div class="col-{{ $layout->col_value }} p-0 section-column"
                                            style="border:1px solid" data-section-layout-id="{{ $layout->id }}">
                                            <!-- Layout Widgets -->
                                            @if (count($layout->layout_widgets))
                                                @foreach ($layout->layout_widgets as $layout_widget)
                                                    <div class="section-widget"
                                                        data-widget="{{ $layout_widget->widget->name }}"
                                                        data-widget-id="{{ $layout_widget->widget->id }}"
                                                        data-layout-widget-id="{{ $layout_widget->id }}">
                                                        @php
                                                            $condition1 = $layout_widget->widget->name == 'flash_deal' && !isActivePlugin('flashdeal-cartlooks');
                                                            $condition2 = $layout_widget->widget->name == 'seller_list' && !isActivePlugin('multivendor-cartlooks');
                                                            $bg = '';
                                                            if ($condition1 || $condition2) {
                                                                $bg = 'bg-deactive';
                                                            }
                                                        @endphp
                                                        <div
                                                            class="card card-body {{ $bg }} flex-row justify-content-between px-3 py-4 flex-wrap gap-10">
                                                            <span
                                                                class="font-14 black bold">{{ $layout_widget->widget->full_name }}</span>

                                                            <div class="widget-icons">
                                                                <a href="javascript:void(0);" class="black dragWidget"><i
                                                                        class="icofont-drag1"></i></a>
                                                                <a href="javascript:void(0);" class="black editWidget"><i
                                                                        class="icofont-options mx-1"></i></a>
                                                                <a href="javascript:void(0);" class="black removeWidget"><i
                                                                        class="icofont-trash"></i></a><a>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <a href="#" class="black my-auto edit-section">
                                    <i class="icofont-options"></i>
                                </a>
                                <a href="#" class="black my-auto ml-2 remove-section">
                                    <i class="icofont-trash"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    @if (!count($sections))
                        <p class="alert alert-danger text-center">{{ translate('No Section Found') }}</p>
                    @endif
                </div>
                <div class="card-footer text-center">
                    <div class="btn btn-primary sm" id="add_new_section_btn">{{ translate('Add New Section') }}</div>
                </div>
            </div>
            <!-- Page Section List End -->
        </div>
        <div class="col-md-4 builder-sidebar">
            <!-- Section/Widget Properties Start -->
            <div class="card mb-30" id="properties-section">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4>{{ translate('Widgets') }}</h4>
                    <a href="#" class="load-widget-list" title="Widgets List">
                        <i class="icofont-brand-microsoft"></i>
                    </a>
                </div>
                <div class="collapse show" id="properties-body">
                    <form action="javascript:void(0);" method="post" id="properties-form">
                        <div class="card-body">
                            <!--Section and widget properties-->
                            <div class="properties-wrapper d-none">
                                <div class="property-fields">
                                    {{-- Section/Widget Properties --}}
                                </div>
                                <div class="form-row save-section mt-3">
                                    <input type="hidden" name="type_key">
                                    <input type="hidden" name="section_id">
                                    <input type="hidden" name="layout_has_widget_id">
                                    <div class="col-12 text-right" id="save-properties">
                                        <img src="{{ asset('/public/loader.svg') }}" alt="loader" class="loader d-none"
                                            width="45px" height="auto">
                                        <button type="submit" class="btn long"
                                            id="save-properties-btn">{{ translate('Save') }}</button>
                                    </div>
                                </div>
                            </div>
                            <!--End section and propewrties-->

                            <!--Widget List-->
                            <div class="widget-list-wrapper">
                                <input type="text" name="" id="widget-search" class="form-control mb-3"
                                    placeholder="{{ translate('Search Widget') }}">
                                <div class="widget-list row">
                                    @foreach ($widgets as $widget)
                                        @if ($widget['name'] == 'flash_deal' && !isActivePlugin('flashdeal-cartlooks'))
                                            @continue
                                        @endif
                                        @if ($widget['name'] == 'seller_list' && !isActivePlugin('multivendor-cartlooks'))
                                            @continue
                                        @endif
                                        <div class="widget-single text-center col-lg-6 mb-2"
                                            data-widget="{{ $widget['name'] }}" data-widget-id="{{ $widget['id'] }}">
                                            <div class="card card-body px-3 py-3">
                                                <div class="popover_wrapper">
                                                    <a href="javascript::void(0)"><i class="icofont-image"></i></a>
                                                    <div class="popover_content">
                                                        <img alt="{{ $widget['name'] }}"
                                                            src="{{ asset('/plugins/pagebuilder-cartlooks/assets/img/' . $widget['name'] . '.png') }}">
                                                    </div>
                                                </div>
                                                <div class="font-14 black bold widget-title">{{ $widget['full_name'] }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!--End Widget List-->
                        </div>
                    </form>
                </div>
            </div>
            <!-- Section/Widget Properties End -->
        </div>
    </div>

    <!--Delete Modal-->
    <div id="delete-modal" class="delete-modal modal fade show" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to delete this') }}?</p>
                    <input type="hidden" id="delete-id" name="id">
                    <input type="hidden" id="section-id" name="section-id">
                    <button type="button" class="btn long mt-2 btn-danger"
                        data-dismiss="modal">{{ translate('cancel') }}</button>
                    <button type="submit" class="btn long mt-2" id="delete-btn">{{ translate('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!--Delete Modal-->

    <!--Layout Select Modal-->
    @include('plugin/pagebuilder-cartlooks::page-builder.includes.layout-modal')
    <!--Layout Select Modal-->

    <!-- Media Modal-->
    @include('core::base.media.partial.media_modal')
    <!-- Media Modal-->
@endsection
@section('custom_scripts')
    <!-- Jquery Ui js -->
    <script src="{{ asset('/public/web-assets/backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Summernote js -->
    <script src="{{ asset('/public/web-assets/backend/plugins/summernote/summernote-lite.js') }}"></script>
    <!--Select2-->
    <script src="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.js') }}"></script>

    <!-- Load The Srcripts -->
    @include('plugin/pagebuilder-cartlooks::page-builder.includes.scripts')
@endsection
