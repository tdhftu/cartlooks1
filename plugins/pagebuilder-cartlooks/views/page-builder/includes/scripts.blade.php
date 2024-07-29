<script>
    (function($) {
        'use strict';
        initDropzone()

        $(document).ready(function() {
            is_for_browse_file = true
            filtermedia()

            // Initialize the ajax token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            //Display widget list
            $(document).on('click', '.load-widget-list', function() {
                loadWidgetList();
            });

            // Widget draggable initialise
            $('.widget-single').draggable({
                revert: "invalid",
                helper: "clone",
                cursor: 'pointer',
                zIndex: 10000,
                start: function(event, ui) {
                    ui.helper.addClass("widget-placeholder");
                    ui.helper.find('.popover_wrapper').remove();
                }
            });

            // Sections sortable initialise
            $('.section-list').sortable({
                cursor: "move",
                revert: "invalid",
                handle: '.drag-layout',
                placeholder: 'widget-placeholder',
                update: function(e, u) {
                    let data = $(this).sortable('serialize');
                    updateSectionOrder(data);
                }
            });

            // Widget Dropable and Sortable initialise
            droppableAndSortableInit();

            // Add New Section Modal show
            $(document).on('click', '#add_new_section_btn', function() {
                $('#layout-modal').modal('show');
            });

            // Select Layout
            $(document).on('change', 'input[name="section_layout"]', function() {
                let layout = $('input[name="section_layout"]:checked').val();
                if (layout) {
                    let order = $('.section-list').children().length + 1;
                    createNewSection(layout, order);
                    $('input[name="section_layout"]:checked').prop('checked', false);
                }
            });

            // Remove Section Modal Show
            $(document).on('click', '.remove-section', function() {
                $('#delete-modal').modal('show');
                let section_id = $(this).parent().attr('id').replace('section_', '');
                $('#delete-id').val(section_id);
                $('#delete-btn').addClass('delete-section-btn');
            });

            // Remove Section button click
            $(document).on('click', '.delete-section-btn', function() {
                let section_id = $('#delete-id').val();
                removeSection(section_id);
                $('#delete-btn').removeClass('delete-section-btn');
            });

            // Edit section button click
            $(document).on('click', '.edit-section', function() {
                let section_id = $(this).parent().attr('id').replace('section_', '');
                getSectionProperties(section_id);
            });

            // Remove Widget Modal Show
            $(document).on('click', '.removeWidget', function() {
                $('#delete-modal').modal('show');
                let layout_widget_id = $(this).parents(':eq(2)').data('layoutWidgetId');
                let section_id = $(this).parents(':eq(5)').attr('id').replace('section_', '');

                $('#delete-id').val(layout_widget_id);
                $('#section-id').val(section_id);

                $('#delete-btn').addClass('delete-widget-btn');
            });

            // Remove Widget button click
            $(document).on('click', '.delete-widget-btn', function() {
                let layout_widget_id = $('#delete-id').val();
                let section_id = $('#section-id').val();
                let widget_name = $('[data-layout-widget-id="' + layout_widget_id + '"]').data(
                    'widget');

                removeWidget(layout_widget_id, section_id, widget_name);
                $('#delete-btn').removeClass('delete-widget-btn');
            });

            // Edit Widget button click
            $(document).on('click', '.editWidget', function() {
                let widget = $(this).parents(':eq(2)').data('widget');
                let section_id = $(this).parents(':eq(5)').attr('id').replace('section_', '');
                let layout_widget_id = $(this).parents(':eq(2)').data('layoutWidgetId');
                let lang = '{{ getDefaultLang() }}';

                getWidgetProperties(widget, layout_widget_id, section_id, lang);
            });

            // Search Widget and filter widget list
            let all_widgets = $('.widget-list').children();
            $(document).on('keyup', '#widget-search', function() {
                let text = $(this).val().toLowerCase();

                let search_widgets = all_widgets.filter((index, widget) => {
                    let widget_name = $(widget).find('.widget-title').text().toLowerCase();
                    return widget_name.includes(text)
                });

                $('.widget-list').empty().append(search_widgets);

                $('.widget-single').draggable({
                    revert: "invalid",
                    helper: "clone",
                    cursor: 'pointer',
                    zIndex: 10000,
                    start: function(event, ui) {
                        ui.helper.addClass("widget-placeholder");
                    }
                });
            });

            // Widget Translate Form
            $(document).on('click', '.lang', function() {
                let widget = $(this).data('widget');
                let lang = $(this).data('lang');
                let section_id = $('#properties-body').find('input[name="section_id"]').val();
                let layout_widget_id = $('#properties-body').find(
                    'input[name="layout_has_widget_id"]').val();

                getWidgetProperties(widget, layout_widget_id, section_id, lang);
            });

            // Submit properties form
            $(document).on('click', '#save-properties-btn', function(e) {
                e.preventDefault();

                // Check Required Field is Not Left Empty
                if (emptyRequiredField()) {
                    toastr.error('Content Fields Are Required', 'Error');
                } else {
                    $('.loader').removeClass('d-none').next().attr('disabled', true);
                    let data = $('#properties-form').serializeArray();
                    var updated_data = {};

                    //Modifying The Form Data
                    $.map(data, function(value) {
                        var name = value['name'];
                        var val = value['value'];

                        if (name.endsWith("[]")) {
                            name = name.slice(0, -2); // Remove "[]"
                            if (!updated_data[name]) {
                                updated_data[name] = [val];
                            } else {
                                updated_data[name].push(val);
                            }
                        } else {
                            updated_data[name] = val;
                        }
                    });

                    updated_data.page = '{{ $data['id'] }}';
                    saveProperties(updated_data);
                }
            });

            // Color Field Value
            $(document).on('input', '.color-picker', function(e) {
                let target = e.target;
                $(target).closest('.addon').find('.color-input').val($(this).val());
            });

            // Range Selector
            $(document).on('input', '.range-selector', function() {
                let input_filed = $(this).attr('id').replace('range_', '');
                $('input[name="' + input_filed + '"]').val($(this).val());
            });

        });

        //Create selected section and make layouts
        function createNewSection(layout, order) {
            $.ajax({
                type: "post",
                url: "{{ route('plugin.builder.pageSection.new') }}",
                data: {
                    layout: layout,
                    page_id: '{{ $data['id'] }}',
                    order: order
                },
                success: function(response) {
                    toastr.success(response.message, 'Success');
                    makeLayout(layout, response.data.section_id, response.data.layout_ids);
                },
                error: function(xhr, status, error) {
                    let message = "{{ translate('Page Section Create Request Failed') }}";
                    if (xhr.responseJSON) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message, 'ERROR!!');
                }
            });
        };

        //Remove selected sections
        function removeSection(section_id) {
            $.ajax({
                type: "post",
                url: "{{ route('plugin.builder.pageSection.remove') }}",
                data: {
                    id: section_id,
                    page_id: '{{ $data['id'] }}',
                    page_permalink: '{{ $data['permalink'] }}'
                },
                success: function(response) {
                    toastr.success(response.message, 'Success');
                    $('#section_' + section_id).remove();
                    $('#delete-modal').modal('hide');
                    if ($('.section-list').children().length < 1) {
                        $('.section-list').after(
                            `<p class="alert alert-danger text-center">No Section Found</p>`);
                    }
                    if (!$('#properties-section').hasClass('d-none')) {
                        loadWidgetList();
                    }
                },
                error: function(xhr, status, error) {
                    let message = "{{ translate('Page Section Remove Request Failed') }}";
                    if (xhr.responseJSON) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message, 'ERROR!!');
                }
            });
        };

        //Update Section Order
        function updateSectionOrder(data) {
            $.ajax({
                type: 'post',
                url: "{{ route('plugin.builder.pageSection.sorting') }}",
                data: data,
                success: function(response) {
                    toastr.success(response.message, 'Success');
                },
                error: function(xhr, status, error) {
                    let message = "{{ translate('Page Section Remove Request Failed') }}";
                    if (xhr.responseJSON) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message, 'ERROR!!');
                }
            });
        };

        // Get Section Properties
        function getSectionProperties(section_id) {
            $.ajax({
                type: "post",
                url: "{{ route('plugin.builder.pageSection.get.properties') }}",
                data: {
                    section_id: section_id
                },
                success: function(response) {
                    $('#save-properties').removeClass('d-none');
                    $('.widget-list-wrapper').addClass('d-none');
                    $('.properties-wrapper').removeClass('d-none');
                    $('.property-fields').html(response.data);
                    $('#properties-section').removeClass('d-none');
                    $('#properties-section').find('h4').html("{{ translate('Section Properties') }}");
                    $('#properties-body').find('input[name="type_key"]').val('section_id');
                    $('#properties-body').find('input[name="section_id"]').val(section_id);
                    $('#properties-body').find('input[name="layout_has_widget_id"]').val('');
                },
                error: function(xhr, status, error) {
                    let message = "{{ translate('Section Edit Request Failed') }}";
                    if (xhr.responseJSON) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message, 'ERROR!!');
                }
            });
        };

        // Make Layout
        function makeLayout(layout, section_id, layout_ids) {
            let colums = layout.split('_');
            let columns_markup = '';
            for (let i = 0; i < colums.length; i++) {
                columns_markup +=
                    `<div class="col-${colums[i]} p-0 section-column" style="border:1px solid" data-section-layout-id="${layout_ids[i]}"></div>`;
            }
            let layout_markup = `
                    <div class ="row" id="section_${section_id}">
                        <a href="#" class="black my-auto drag-layout">
                            <i class="icofont-drag"></i>
                        </a>
                        <div class="row my-2 mx-0 col-11 bg-white layout-height">` + columns_markup + `</div>
                        <a href="#" class="black my-auto edit-section">
                            <i class="icofont-options"></i>
                        </a>
                        <a href="#" class="black my-auto ml-2 remove-section">
                            <i class="icofont-trash"></i>
                        </a>
                    </div>
                `;

            $('.section-list').next().remove();
            $('.section-list').append(layout_markup);
            $('#layout-modal').modal('hide');
            droppableAndSortableInit();
        };

        // Save to widget to database
        function saveWidget(data, widget, section) {
            $.ajax({
                type: "post",
                url: "{{ route('plugin.builder.pageSection.widget.add') }}",
                data: {
                    section_layout_id: data.section_layout_id,
                    widget_id: data.widget_id
                },
                success: function(response) {
                    toastr.success(response.message, 'Success');
                    appendWidgetToLayout(widget, section, response.data.id);
                    updateWidgetOrder(data.section_layout_id);
                },
                error: function(xhr, status, error) {
                    let message = "{{ translate('Widget Adding Request Failed') }}";
                    if (xhr.responseJSON) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message, 'ERROR!!');
                }
            });
        };

        // Remove widget from layouts and database
        function removeWidget(layout_widget_id, section_id, widget_name) {
            $.ajax({
                type: "post",
                url: "{{ route('plugin.builder.pageSection.widget.remove') }}",
                data: {
                    layout_widget_id: layout_widget_id,
                    section_id: section_id,
                    widget_name: widget_name,
                    page_permalink: '{{ $data['permalink'] }}'
                },
                success: function(response) {
                    toastr.success(response.message, 'Success');
                    let element = $('[data-layout-widget-id="' + layout_widget_id + '"]');
                    let layout_id = element.parent().data('sectionLayoutId');
                    element.remove();
                    $('#delete-modal').modal('hide');
                    updateWidgetOrder(layout_id);
                    if (!$('#properties-section').hasClass('d-none')) {
                        loadWidgetList();
                    }
                },
                error: function(xhr, status, error) {
                    let message = "{{ translate('Widget Removing Request Failed') }}";
                    if (xhr.responseJSON) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message, 'ERROR!!');
                }
            });
        };

        // Update widget position by sorting widget
        function changeWidgetPosition(data) {
            $.ajax({
                type: "post",
                url: "{{ route('plugin.builder.pageSection.widget.updatePosition') }}",
                data: {
                    ...data
                },
                success: function(response) {
                    toastr.success(response.message, 'Success');
                    updateWidgetOrder(data.new_layout_id);
                    if (!$('#properties-section').hasClass('d-none')) {
                        $('#properties-section').addClass('d-none');
                    }
                },
                error: function(xhr, status, error) {
                    let message = "{{ translate('Widget Position Update Request Failed') }}";
                    if (xhr.responseJSON) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message, 'ERROR!!');
                }
            });
        };

        // Update Widget Order
        function updateWidgetOrder(layout_id) {
            $('.section-column').sortable("disable");
            let data = $('[data-section-layout-id="' + layout_id + '"]').children();
            let layout_widget_ids = [];
            data.each(function(index, element) {
                layout_widget_ids.push($(element).data('layoutWidgetId'));
            });

            if (layout_widget_ids.length) {
                $.ajax({
                    type: "post",
                    url: "{{ route('plugin.builder.pageSection.widget.order') }}",
                    data: {
                        layout_id: layout_id,
                        layout_widget_ids: layout_widget_ids
                    },
                    success: function(response) {
                        $('.section-column').sortable("enable");
                    },
                    error: function(xhr, status, error) {
                        let message = "{{ translate('Widget Order Request Failed') }}";
                        if (xhr.responseJSON) {
                            message = xhr.responseJSON.message;
                        }
                        toastr.error(message, 'ERROR!!');
                    }
                });
            }
        };

        // Will initialise the droppable and sortable of widget
        function droppableAndSortableInit() {
            // Section column droppable for widgets initialise
            $('.section-column').droppable({
                accept: ".widget-single",
                drop: function(event, ui) {
                    let widget = $(ui.draggable).clone();
                    const data = {
                        widget_id: $(widget).data('widgetId'),
                        section_layout_id: $(this).data('sectionLayoutId')
                    };
                    saveWidget(data, widget, this);
                },
            });

            // Section columns are sortable initialise
            $('.section-column').sortable({
                cursor: "move",
                revert: "invalid",
                handle: '.dragWidget',
                connectWith: ".section-column",
                placeholder: 'widget-placeholder',
                update: function(event, ui) {
                    let ownlist = ui.sender == null;
                    if (!ownlist) {
                        let data = {
                            widget_id: $(ui.item).data('widgetId'),
                            layout_widget_id: $(ui.item).data('layoutWidgetId'),
                            new_layout_id: $(this).data('sectionLayoutId'),
                            prev_layout_id: $(ui.sender).data('sectionLayoutId'),
                            new_section_id: $(this).parents(':eq(1)').attr('id').replace('section_',
                                ''),
                            prev_section_id: $(ui.sender).parents(':eq(1)').attr('id').replace(
                                'section_', ''),
                            page_permalink: '{{ $data['permalink'] }}'
                        };
                        changeWidgetPosition(data);
                    } else {
                        updateWidgetOrder($(this).data('sectionLayoutId'));
                    }
                }
            });
        };

        // Load Widget list
        function loadWidgetList() {
            $('.widget-list-wrapper').removeClass('d-none');
            $('.properties-wrapper').addClass('d-none');
            $('#properties-section').find('h4').html("{{ translate('Widgets') }}");
        }

        // Append new widget to layout
        function appendWidgetToLayout(widget, section, id) {
            $(widget).removeClass('mb-2');
            $(widget).removeClass('text-center');
            $(widget).removeClass('col-lg-6');
            $(widget).removeClass('widget-single').addClass('section-widget');
            $(widget).removeClass('ui-draggable');
            $(widget).removeClass('ui-draggable-handle');
            $(widget).find('.popover_wrapper').remove();
            $(widget).attr('data-layout-widget-id', id);
            $(widget).find('.card').addClass('flex-row justify-content-between flex-wrap gap-10')
            $(widget).appendTo(section);
            let actionMarkup = `
                        <div class="widget-icons">
                            <a href="javascript:void(0);" class="black dragWidget"><i class="icofont-drag1"></i></a>
                            <a href="javascript:void(0);" class="black editWidget"><i class="icofont-options mx-1"></i></a>
                            <a href="javascript:void(0);" class="black removeWidget"><i class="icofont-trash"></i><a>
                        </div>`;
            $(widget).find('.card').append(actionMarkup);
        };

        // Get Widget Properties Form
        function getWidgetProperties(widget, layout_widget_id, section_id, lang) {
            $.ajax({
                type: "post",
                url: "{{ route('plugin.builder.pageSection.widget.get.properties') }}",
                data: {
                    widget_name: widget,
                    layout_widget_id: layout_widget_id,
                    lang: lang
                },
                success: function(response) {
                    $('.widget-list-wrapper').addClass('d-none');
                    $('.properties-wrapper').removeClass('d-none');
                    $('.property-fields').html(response.data);
                    $('#properties-section').removeClass('d-none');
                    let widget_title = widget.split('_').map((str) => str.charAt(0).toUpperCase() + str
                            .slice(1)).join(' ') + ' ' +
                        "{{ translate('Properties') }}"
                    $('#properties-section').find('h4').html(widget_title);
                    $('#properties-body').find('input[name="type_key"]').val('layout_has_widget_id');
                    $('#properties-body').find('input[name="section_id"]').val(section_id);
                    $('#properties-body').find('input[name="layout_has_widget_id"]').val(
                        layout_widget_id);

                    // Dissable Fields if not default language
                    if (lang != "{{ getDefaultLang() }}") {
                        dissableNotTranslatedField();
                    }

                    if (widget == 'banner') {
                        $('#save-properties').addClass('d-none');
                    } else if (widget == 'service_feature') {
                        $('#save-properties').addClass('d-none');
                    } else {
                        $('#save-properties').removeClass('d-none');
                    }
                },
                error: function(xhr, status, error) {
                    let message = "{{ translate('Widget Edit Request Failed') }}";
                    if (xhr.responseJSON) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message, 'ERROR!!');
                }
            });
        };

        // Save Section/Widget Properties
        function saveProperties(data) {
            let url = "{{ route('plugin.builder.pageSection.widget.update.properties') }}";
            if (data.type_key == 'section_id') {
                url = "{{ route('plugin.builder.pageSection.update.properties') }}"
            }
            $.ajax({
                type: "post",
                url: url,
                data: {
                    ...data
                },
                success: function(response) {
                    toastr.success(response.message, 'Success');
                },
                error: function(xhr, status, error) {
                    let message = "{{ translate('Properties Update Request Failed') }}";
                    if (xhr.responseJSON) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message, 'ERROR!!');
                },
                complete: function(param) {
                    $('.loader').addClass('d-none').next().attr('disabled', false);
                }
            });
        };

        // Dissable All Fields That Are Not For Translate
        function dissableNotTranslatedField() {
            $('#myTabContent .form-group, #myTabContent .form-row').each(function(index, element) {
                if (!$(element).hasClass('translate-field')) {
                    $(element).addClass('area-disabled');
                }
            });
        }

        //Check If Required Field is Empty
        function emptyRequiredField() {
            let empty = false;
            $("#properties-form :input[required]").each(function() {
                if ($(this).val() === "") {
                    empty = true;
                    return false; // Exit the loop early
                }
            });
            return empty;
        }

        /**
         * Feature Modal Open
         **/
        $(document).on('click', '.feature-item', function() {
            let key = $(this).data('key');
            let details = $(this).data('details');
            let lang = $(this).data('lang')

            $.ajax({
                type: "get",
                url: '{{ route('plugin.builder.pageSection.feature.show') }}',
                data: {
                    key,
                    details,
                    lang
                },
                success: function(response) {
                    $('#feature-create-modal .modal-body').html(response.data);
                    $('#feature-create-modal').modal('show');
                },
                error: function(xhr, status, error) {
                    let message = "{{ translate('New Banner Slide Open Failed') }}";
                    if (xhr.responseJSON) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message, 'ERROR!!');
                }
            });
        });

        /**
         * Save Feature Option
         **/
        $(document).on('click', '#save-btn', function() {
            const fields = ['title', 'sub_title', 'image_id'];
            let layout_widget_id = $('#properties-body').find('input[name="layout_has_widget_id"]').val();
            let key = $('#feature_key').val();
            let lang = $('#lang').val();
            let data = checkValidation(fields);
            console.log(key);
            console.log(lang)

            if (Object.keys(data).length === 3) {
                $.ajax({
                    type: "post",
                    url: '{{ route('plugin.builder.pageSection.feature.save') }}',
                    data: {
                        layout_widget_id,
                        key,
                        lang,
                        ...data
                    },
                    success: function(response) {
                        toastr.success(response.message, 'Success!!');

                        $('.slider-list button[data-key="' + key + '"]').text(response.data
                            .title);
                        $('.slider-list button[data-key="' + key + '"]').data('details',
                            response.data.details);
                        $('#feature-create-modal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        let message = "{{ translate('New Feature Saving Failed') }}";
                        if (xhr.responseJSON) {
                            message = xhr.responseJSON.message;
                        }
                        toastr.error(message, 'ERROR!!');
                    }
                });
            }
        });


        /** 
         * Check Field Validation 
         **/
        function checkValidation(fields) {
            let data = {}
            for (let field of fields) {
                let value = $('#' + field).val().trim();
                if (value == '') {
                    $('.' + field + '-feedback').removeClass('d-none');
                } else {
                    $('.' + field + '-feedback').addClass('d-none');
                    data[field] = value;
                }
            }
            return data;
        }
    })(jQuery);
</script>
