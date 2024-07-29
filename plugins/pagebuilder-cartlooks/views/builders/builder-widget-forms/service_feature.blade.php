<ul class="nav nav-tabs mb-20" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="content-info-tab" data-toggle="tab" href="#content-info" role="tab"
            aria-controls="content-info" aria-selected="true">{{ translate('Content') }}</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">

    <!-- Content Properties -->
    <div class="tab-pane fade show active" id="content-info" role="tabpanel" aria-labelledby="content-info-tab">
        @include('plugin/pagebuilder-cartlooks::page-builder.includes.lang-translate', [
            'lang' => $lang,
            'widget' => 'service_feature',
        ])
        <button class="btn btn-dark sm" id="add_feature" type="button">{{ translate('Add New Feature') }}</button>

        <div class="slider-list my-3">
            @isset($widget_properties)
                @foreach ($widget_properties as $key => $slide)
                    <button class="btn btn-border sm btn-block radius-0 feature-item" data-lang="{{ $lang }}"
                        data-key="{{ $key }}" data-details="{{ json_encode($slide) }}"
                        type="button">{{ $slide['title'] }}</button>
                @endforeach
            @endisset

        </div>
    </div>

</div>

<!--Create Modal-->
<div id="feature-create-modal" class="feature-create-modal modal fade show" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ translate('Feature Information') }}</h4>
                    <button type="button" class="btn-dark" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer justify-content-around">
                <button type="button" class="btn btn-danger long mt-2"
                    id="feature-delete-btn">{{ translate('Delete') }}</button>
                <button type="button" class="btn long mt-2" id="save-btn">{{ translate('Save') }}</button>
            </div>
        </div>
    </div>
</div>
<!--Create Modal-->

<script>
    (function($) {
        'use strict'

        /**
         * Add New Feature
         **/
        $('#add_feature').on('click', function(e) {
            e.preventDefault();
            let slide_count = $('.slider-list').children().length;
            let slide = slide_count != 0 ? $('.slider-list button:last-child').data('key') : slide_count;
            $('.slider-list').append(`
                <button class="btn btn-border sm btn-block radius-0 feature-item" data-key="${slide+1}" data-details="" type="button">Unnamed Feature</button>
            `);
        });

        /**
         * Delete feature
         **/
        $('#feature-delete-btn').on('click', function() {
            let key = $('#slide-key').val();
            let layout_widget_id = $('#properties-body').find('input[name="layout_has_widget_id"]').val();

            $.ajax({
                type: "delete",
                url: '{{ route('plugin.builder.pageSection.feature.delete') }}',
                data: {
                    key,
                    layout_widget_id
                },
                success: function(response) {
                    $('.slider-list button[data-key="' + key + '"]').remove();
                    $('#feature-create-modal').modal('hide');
                    toastr.success(response.message, 'Success!!');
                },
                error: function(xhr, status, error) {
                    let message = "{{ translate('Feature Deleting Failed') }}";
                    if (xhr.responseJSON) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message, 'ERROR!!');
                }
            });
        })

    })(jQuery);
</script>
