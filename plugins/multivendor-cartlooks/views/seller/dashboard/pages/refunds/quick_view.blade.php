<link href="{{ asset('/public/web-assets/backend/plugins/summernote/summernote-lite.css') }}" rel="stylesheet" />
@if ($action == 'quick-view')
    <div class="row">
        <!--Product info-->
        <div class="col-12">
            <div class="product-list-group">
                <div class="product-list p-3 border">
                    <!--Product info-->
                    <div class="align-items-center product-information row">
                        <div class="col-12">
                            @if ($details->product != null)
                                <div class="align-items-center d-flex product-info">
                                    <div class="image"><img
                                            src="{{ getFilePath($details->product->thumbnail_image, true) }}"
                                            alt="{{ $details->product->name }}" class="img-70 rounded">
                                    </div>
                                    <div class="title">
                                        <h5>{{ $details->product->name }}</h5>
                                        <div class="d-flex gap-10">
                                            <div class="price"><span>Qty {{ $details->quantity }}</span></div>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        </div>
                    </div>
                    <!--End product info-->
                </div>
            </div>
        </div>
        <!--End product info-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table mar-no">
                    <tbody>
                        <tr>
                            <td>{{ translate('Amount') }}</td>
                            <td>
                                {!! currencyExchange($details->total_amount) !!}
                            </td>
                        </tr>
                        @if ($details->reason != null)
                            <tr>
                                <td>{{ translate('Reason') }}</td>
                                <td>

                                    <p>{{ $details->reason->name }}</p>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>{{ translate('Note') }}</td>
                            <td>
                                {{ $details->comment }}
                            </td>
                        </tr>
                        <tr>
                            <td>{{ translate('Attachements') }}</td>
                            <td>
                                @if ($details->images != null)
                                    <div class="align-items-center d-flex file-preview-item gap-10 mt-2">
                                        @php
                                            $images = substr($details->images, 1, -1);
                                            $images = explode(',', $images);
                                        @endphp
                                        @foreach ($images as $image)
                                            <a href="{{ getFilePath($image, true) }}" target="_blank"
                                                class="d-block text-reset">
                                                <div
                                                    class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                    <img src="{{ getFilePath($image, true) }}" class="img-fit">
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <form id="update_status_form">
                @csrf
                <input type="hidden" name="request_id" value="{{ $details->id }}">
                <!--Delivery status-->
                <div class="form-row mb-20">
                    <label class="font-14 bold black">{{ translate('Return Status') }}<span
                            class="text text-danger">*</span></label>
                    <select class="theme-input-style" name="return_status" id="return_status">
                        <option value="{{ config('cartlookscore.return_request_status.pending') }}"
                            @selected($details->return_status == config('cartlookscore.return_request_status.pending'))>
                            {{ translate('Pending') }}
                        </option>
                        <option value="{{ config('cartlookscore.return_request_status.processing') }}"
                            @selected($details->return_status == config('cartlookscore.return_request_status.processing'))>
                            {{ translate('Processing') }}
                        </option>
                        <option value="{{ config('cartlookscore.return_request_status.product_received') }}"
                            @selected($details->return_status == config('cartlookscore.return_request_status.product_received'))>
                            {{ translate('Product Received') }}
                        </option>
                        <option value="{{ config('cartlookscore.return_request_status.cancelled') }}"
                            @selected($details->return_status == config('cartlookscore.return_request_status.cancelled'))>
                            {{ translate('Cancelled') }}
                        </option>
                    </select>
                </div>
                <!--End delivery status-->
                <!--Comment-->
                <div class="form-row mb-20">
                    <label class="font-14 bold black col-12">{{ translate('Comment') }}</label>
                    <div class="editor-wrap col-12">
                        <textarea name="comment" id="request-comment" class="theme-input-style h-25" rows="2"></textarea>
                    </div>
                </div>
                <!--End comment-->
                <div class="form-row">
                    <div class="col-12 text-right">
                        <button
                            class="btn long update-request-status rounded">{{ translate('Update Status') }}</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endif
<script src="{{ asset('/public/web-assets/backend/plugins/summernote/summernote-lite.js') }}"></script>
<script>
    (function($) {
        "use strict";
        /**
         * Summer note
         * 
         **/
        $("#request-comment").summernote({
            tabsize: 2,
            height: 150,
            codeviewIframeFilter: false,
            codeviewFilter: true,
            codeviewFilterRegex: /<\/*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|ilayer|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|t(?:itle|extarea)|xml)[^>]*>|on\w+\s*=\s*"[^"]*"|on\w+\s*=\s*'[^']*'|on\w+\s*=\s*[^\s>]+/gi,
            toolbar: [
                ["style", ["style"]],
                ["font", ["fontname", "bold", "underline", "clear"]],
                ["color", ["color"]],
                ['insert', ['link']],
                ["view", ["fullscreen", "codeview", "help"]],
            ],
            callbacks: {
                onChangeCodeview: function(contents, $editable) {
                    let code = $(this).summernote('code')
                    code = code.replace(
                        /<\/*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|ilayer|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|t(?:itle|extarea)|xml)[^>]*>|on\w+\s*=\s*"[^"]*"|on\w+\s*=\s*'[^']*'|on\w+\s*=\s*[^\s>]+/gi,
                        '')
                    $(this).val(code)
                }
            }
        });
        /**
         * Status update of refund request 
         * 
         **/
        $(".update-request-status").on('click', function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: "POST",
                data: $("#update_status_form").serialize(),
                url: '{{ route('plugin.multivendor.seller.dashboard.refund.request.status.update') }}',
                success: function(response) {
                    if (response.success) {
                        toastr.success('{{ translate('Request status successfully') }}');
                        location.reload();
                    } else {
                        toastr.error('{{ translate('Request status update failed') }}');
                    }
                },
                error: function(response) {
                    if (response.status == 422) {
                        $.each(response.responseJSON.errors, function(field_name, error) {
                            $(document).find('[name=' + field_name + ']').closest(
                                '.input-option').after(
                                '<div class="invalid-input">' + error + '</div>')
                        })
                    } else {
                        toastr.error('{{ translate('Update Failed ') }}');
                    }
                }
            });
        });
    })(jQuery);
</script>
