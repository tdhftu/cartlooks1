@extends('core::base.layouts.master')

@section('title')
    {{ translate('Edit Blog') }}
@endsection

@section('custom_css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.css') }}">
    <!--  End select2  -->
    <!--Editor-->
    <link href="{{ asset('/public/web-assets/backend/plugins/summernote/summernote-lite.css') }}" rel="stylesheet" />
    <!--End editor-->
@endsection

@section('main_content')
    <!-- Main Content -->
    <form class="form-horizontal my-4" id="blog_form" action="{{ route('core.update.blog') }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <input type="hidden" id="blog_id" name="id" value="{{ $blog->id }}">
        <input type="hidden" name="lang" value="{{ $lang }}">

        <div class="row">
            <div class="col-md-8">
                {{-- Languages --}}
                <div class="row">
                    <div class="col-12 mb-3">
                        <p class="alert alert-info">You are editing <strong>"{{ getLanguageNameByCode($lang) }}"</strong>
                            version</p>
                    </div>
                    <div class="col-12">
                        <ul class="nav nav-tabs nav-fill border-light border-0">
                            @foreach ($languages as $key => $language)
                                <li class="nav-item">
                                    <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-3"
                                        href="{{ route('core.edit.blog', ['id' => $blog->id, 'lang' => $language->code]) }}">
                                        <img src="{{ asset('/public/web-assets/backend/img/flags/') . '/' . $language->code . '.png' }}"
                                            width="20px">
                                        <span>{{ $language->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card mb-30">
                    <div class="card-body">
                        {{-- Name Field --}}
                        <div class="form-group row my-4">
                            <label for="name" class="col-sm-2 font-14 bold black">{{ translate('Title') }}<span
                                    class="text-danger"> * </span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name"
                                    class="form-control @if (!empty($lang) && $lang == getdefaultlang()) blog_name @endif"
                                    value="{{ $blog->translation('name', $lang) }}" placeholder="{{ translate('Name') }}"
                                    required>
                                <input type="hidden" name="permalink" id="permalink_input_field"
                                    value="{{ $blog->permalink }}" required>
                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>
                        {{-- Name Field End --}}
                        <!--Permalink-->
                        <div
                            class="form-row my-4 permalink-input-group @if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
                            <div class="col-sm-2">
                                <label class="font-14 bold black">{{ translate('Permalink') }} </label>
                            </div>
                            <div class="col-sm-10">
                                {{-- if blog is publish or schedule link to frontend or Preview --}}
                                @if ($blog->is_publish == config('settings.blog_status.publish'))
                                    <a href="/blog/{{ $blog->permalink }}">{{ url('') }}/blog/<span
                                            id="permalink">{{ $blog->permalink }}</span><span
                                            class="btn custom-btn ml-1 permalink-edit-btn">{{ translate('Edit') }}</span></a>
                                @else
                                    <a href="#" onclick="blogPreviewDraft('preview')">{{ url('') }}/blog/<span
                                            id="permalink">{{ $blog->permalink }}</span><span
                                            class="btn custom-btn ml-1 permalink-edit-btn">{{ translate('Edit') }}</span></a>
                                @endif

                                @if ($errors->has('permalink'))
                                    <div class="invalid-input">{{ $errors->first('permalink') }}</div>
                                @endif
                                <div class="permalink-editor d-none">
                                    <input type="text" class="theme-input-style" id="permalink-updated-input"
                                        placeholder="{{ translate('Type here') }}">
                                    <button type="button" class="btn long mt-2 btn-danger permalink-cancel-btn"
                                        data-dismiss="modal">{{ translate('Cancel') }}</button>
                                    <button type="button"
                                        class="btn long mt-2 permalink-save-btn">{{ translate('Save') }}</button>
                                </div>
                            </div>
                        </div>
                        <!--End Permalink-->

                        {{-- Short Description Field --}}
                        <div class="form-row my-4">
                            <label for="short_description"
                                class="col-sm-2 font-14 bold black">{{ translate('Short Description') }}<span
                                    class="text-danger"> * </span></label>
                            <div class="col-sm-10">
                                <textarea name="short_description" class="theme-input-style h-100" placeholder="{{ translate('Short Description') }}">{{ $blog->translation('short_description', $lang) }}</textarea>
                                @if ($errors->has('short_description'))
                                    <p class="text-danger">{{ $errors->first('short_description') }}</p>
                                @endif
                            </div>
                        </div>
                        {{-- Short Description Field End --}}

                        {{-- Content Field --}}
                        <div class="form-group row my-4">
                            <label class="col-sm-2 font-14 bold black">{{ translate('Content') }}<span class="text-danger">
                                    * </span></label>
                            <div class="col-sm-10">
                                <div class="editor-wrap">
                                    <textarea name="content" id="blog_content" data-href="">{{ $blog->translation('content', $lang) }}</textarea>
                                </div>
                                @if ($errors->has('content'))
                                    <p class="text-danger"> {{ $errors->first('content') }} </p>
                                @endif
                            </div>
                        </div>
                        {{-- Content Field End --}}
                    </div>
                </div>


                {{-- Seo Information --}}
                <div class="@if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
                    <div class="card mb-20">
                        <div class="card-header bg-white py-3">
                            <h4>{{ translate('Blog Seo Meta') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row mb-20">
                                <div class="col-sm-2">
                                    <label class="font-14 bold black ">{{ translate('Meta Title') }} </label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" name="meta_title" class="theme-input-style"
                                        placeholder="{{ translate('Type here') }}" value="{{ $blog->meta_title }}">
                                    @if ($errors->has('meta_title'))
                                        <div class="invalid-input">{{ $errors->first('meta_title') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row mb-20">
                                <div class="col-sm-2">
                                    <label class="font-14 bold black ">{{ translate('Meta Description') }} </label>
                                </div>
                                <div class="col-sm-10">
                                    <textarea class="theme-input-style" name="meta_description">{{ $blog->meta_description }}</textarea>
                                    @if ($errors->has('meta_description'))
                                        <div class="invalid-input">{{ $errors->first('meta_description') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row mb-20">
                                <div class="col-sm-2">
                                    <label class="font-14 bold black ">{{ translate('Meta Image') }} </label>
                                </div>
                                <div class="col-sm-10">
                                    @include('core::base.includes.media.media_input', [
                                        'input' => 'meta_image',
                                        'data' => $blog->meta_image,
                                    ])
                                    @if ($errors->has('meta_image'))
                                        <div class="invalid-input">{{ $errors->first('meta_image') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Seo Information End --}}
            </div>


            {{-- Edit Blog Side Field --}}
            <div class="col-md-4">
                <div class="row">
                    {{-- Publish Section --}}
                    <div class="col-12 mb-20 order-last order-md-first">
                        <div class="card mt-5 mt-md-0 p-0">
                            <div class="card-header bg-white py-3">
                                <h4>{{ translate('Publish') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="@if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
                                    {{-- Draft,previe,pending button --}}
                                    <div class="row my-4 mx-1 justify-content-between ">
                                        <div>
                                            <a href="#" class="btn btn-dark sm mr-2"
                                                onclick="blogPreviewDraft('draft')">{{ translate('Draft') }}</a>
                                            <a href="#" class="btn btn-info sm mr-2"
                                                onclick="blogPreviewDraft('pending')">{{ translate('Pending') }}</a>
                                        </div>
                                        <a href="#" class="btn sm mr-2"
                                            onclick="blogPreviewDraft('preview')">{{ translate('Preview') }}</a>
                                    </div>

                                    {{-- visibility part --}}
                                    <input type="hidden" name="visibility" id="visibility-radio-public"
                                        value="public" />
                                    {{-- visibility part end --}}

                                    {{-- publish schedule part --}}
                                    <div class="row my-2 mx-1">
                                        <i class="icofont-ui-calendar icofont-1x mt-2"></i>
                                        <label for="publish_at"
                                            class="font-14 black ml-1 mt-2">{{ translate('Publish') }}
                                            :</label>
                                        <input type="datetime-local" name="publish_at" id="publish_at"
                                            class="theme-input-style w-75 ml-2 py-0" value="{{ $blog->publish_at }}">
                                    </div>
                                    {{-- publish schedule part end --}}
                                </div>

                                <div class="row mx-1 mt-4 ">
                                    <button type="submit"
                                        class="col-sm-4 btn sm btn-primary">{{ translate('Update') }}</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- Publish Section End --}}

                    <div class="col-12  @if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
                        {{-- Select category --}}
                        <div class="card p-0 mb-20">
                            <div class="card-header py-3 bg-white">
                                <h4>{{ translate('Blog Categories') }}</h4>
                            </div>
                            <div class="card-body">
                                <div id="category_select_load">
                                    {{-- Ajax Category Load --}}
                                </div>
                                @if ($errors->has('categories'))
                                    <p class="text-danger my-3 px-2">{{ $errors->first('categories') }}</p>
                                @endif
                            </div>
                        </div>
                        {{-- Select category End --}}

                        {{-- Select Tags --}}
                        <div class="card p-0 mb-20">
                            <div class="card-header py-3 bg-white">
                                <h4>{{ translate('Blog Tags') }}</h4>
                            </div>
                            <div class="card-body">
                                <div id="tag_select_load">
                                    {{-- Ajax Tag Load --}}
                                </div>
                            </div>
                        </div>
                        {{-- Select Tags End --}}

                        {{-- Blog Image --}}
                        <div class="card mb-20">
                            <div class="card-header bg-white py-3">
                                <h4>{{ translate('Blog Image') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group justify-content-center">
                                    <div class="col-sm-4">
                                        @include('core::base.includes.media.media_input', [
                                            'input' => 'blog_image',
                                            'data' => $blog->image,
                                        ])
                                        @if ($errors->has('image'))
                                            <p class="text-danger"> {{ $errors->first('image') }} </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Blog Image End --}}

                        {{-- Blog Status --}}
                        <div class="card">
                            <div class="card-header bg-white py-3">
                                <h4>{{ translate('Featured Blog') }}</h4>
                            </div>
                            <div class="card-body">
                                {{-- Blog - Featured Field --}}
                                <div class="form-row">
                                    <label for="is_featured"
                                        class="col-sm-6 font-14 bold black">{{ translate('Status') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="is_featured" @checked($blog->is_featured == 1)>
                                            <span class="control"></span>
                                        </label>
                                        @if ($errors->has('is_featured'))
                                            <p class="text-danger">{{ $errors->first('is_featured') }}</p>
                                        @endif
                                    </div>
                                </div>
                                {{-- Blog - Featured Field End --}}
                            </div>

                        </div>
                        {{-- Blog Status End --}}
                    </div>
                </div>
            </div>
            {{-- Edit Blog Side Field End --}}
        </div>
    </form>

    @include('core::base.media.partial.media_modal')
    <!-- End Main Content -->
@endsection


@section('custom_scripts')
    <!--Select2-->
    <script src="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.js') }}"></script>
    <!--End Select2-->
    <!--Editor-->
    <script src="{{ asset('/public/web-assets/backend/plugins/summernote/summernote-lite.js') }}"></script>
    <!--End Editor-->

    <script>
        (function($) {
            "use strict";
            initDropzone()
            $(document).ready(function() {
                is_for_browse_file = true
                filtermedia()

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                // category load via ajax
                $.ajax({
                    type: "post",
                    url: '{{ route('core.blog.category.load') }}',
                    data: {
                        id: $('#blog_id').val(),
                    },
                    success: function(res) {

                        $('#category_select_load').html(res.view);

                        ButtonToggle('#add_new_category_button', '.category-create-form');

                        let selected_categories = [];
                        if (res.blog_category != null) {

                            $.each(res.blog_category, function(index, value) {
                                selected_categories.push(value);
                            });
                            $('#category-select').val(selected_categories);
                        }
                        selectPlugin('#category-select'); //select plugin add

                        $('#add_category_button').on('click', function() {
                            saveCategory();
                        });
                    },
                    error: function(data, textStatus, jqXHR) {
                        toastr.error('Category Loading Failed', 'ERROR!!');
                    }
                });

                // save category via ajax
                function saveCategory() {
                    let category = $('#category_input').val();
                    if (category == '') {
                        return false;
                    }
                    let permalink = string_to_slug(category);
                    let parent = $('.parentCategorySelect option:selected').val();
                    let selected_categories = $('#category-select').val();
                    let id = $('#blog_id').val();

                    $.ajax({
                        type: "post",
                        url: '{{ route('core.blog.category.load') }}',
                        data: {
                            category: category,
                            permalink: permalink,
                            parent: parent,
                            id: id,
                        },
                        success: function(res) {

                            if (res.error) {
                                toastr.error(res.error, 'ERROR!!');
                            } else {

                                $('#category_select_load').html(res.view);
                                $('.category-create-form').removeClass('d-none');

                                if (res.id != null) {
                                    selected_categories.push(res.id);
                                    $('#category-select').val(selected_categories);
                                    selectPlugin('#category-select'); //select plugin add
                                }

                                $('#add_category_button').on('click', function() {
                                    saveCategory();
                                });
                                ButtonToggle('#add_new_category_button', '.category-create-form');
                            }
                        },
                        error: function(data, textStatus, jqXHR) {
                            toastr.error('Category Loading Failed', 'ERROR!!');
                        }
                    });

                }

                // tag load via ajax
                $.ajax({
                    type: "post",
                    url: '{{ route('core.blog.tag.load') }}',
                    data: {
                        id: $('#blog_id').val(),
                    },
                    success: function(res) {

                        $('#tag_select_load').html(res.view);
                        ButtonToggle('#add_new_tag_button', '.tag-create-form');

                        let selected_tags = [];
                        if (res.blog_tag != null) {

                            $.each(res.blog_tag, function(index, value) {
                                selected_tags.push(value);
                            });
                            $('#tag-select').val(selected_tags);
                        }
                        selectPlugin('#tag-select'); //select plugin add

                        $('#add_tag_button').on('click', function() {
                            saveTag();
                        });
                    },
                    error: function(data, textStatus, jqXHR) {
                        toastr.error('Tag Loading Failed', 'ERROR!!');
                    }
                });

                // save Tag via ajax
                function saveTag() {
                    let tag = $('#tag_input').val();
                    if (tag == '') {
                        return false;
                    }
                    let permalink = string_to_slug(tag);
                    let selected_tags = $('#tag-select').val();
                    let id = $('#blog_id').val();

                    $.ajax({
                        type: "post",
                        url: '{{ route('core.blog.tag.load') }}',
                        data: {
                            tag: tag,
                            permalink: permalink,
                            id: id,
                        },
                        success: function(res) {

                            if (res.error) {
                                toastr.error(res.error, 'ERROR!!');
                            } else {

                                $('#tag_select_load').html(res.view);
                                $('.tag-create-form').removeClass('d-none');

                                if (res.id != null) {
                                    selected_tags.push(res.id);
                                    $('#tag-select').val(selected_tags);
                                    selectPlugin('#tag-select'); //select plugin add
                                }

                                $('#add_tag_button').on('click', function() {
                                    saveTag();
                                });

                                ButtonToggle('#add_new_tag_button', '.tag-create-form');
                            }
                        },
                        error: function(data, textStatus, jqXHR) {
                            toastr.error('Tag Loading Failed', 'ERROR!!');
                        }
                    });

                }

                // SUMMERNOTE INIT
                $('#blog_content').summernote({
                    tabsize: 2,
                    height: 200,
                    codeviewIframeFilter: false,
                    codeviewFilter: true,
                    codeviewFilterRegex: /<\/*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|ilayer|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|t(?:itle|extarea)|xml)[^>]*>|on\w+\s*=\s*"[^"]*"|on\w+\s*=\s*'[^']*'|on\w+\s*=\s*[^\s>]+/gi,
                    toolbar: [
                        ["style", ["style"]],
                        ['fontsize', ['fontsize']],
                        ["font", ["bold", "underline", "clear"]],
                        ["color", ["color"]],
                        ["para", ["ul", "ol", "paragraph"]],
                        ["table", ["table"]],
                        ["insert", ["link", "picture", "video"]],
                        ["view", ["fullscreen", "codeview"]],

                    ],
                    placeholder: 'Blog Content',
                    callbacks: {
                        onImageUpload: function(images, editor, welEditable) {
                            sendFile(images[0], editor, welEditable);
                        },
                        onChangeCodeview: function(contents, $editable) {
                            let code = $(this).summernote('code')
                            code = code.replace(
                                /<\/*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|ilayer|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|t(?:itle|extarea)|xml)[^>]*>|on\w+\s*=\s*"[^"]*"|on\w+\s*=\s*'[^']*'|on\w+\s*=\s*[^\s>]+/gi,
                                '')
                            $(this).val(code)
                        }
                    }
                });
            });

            /*Generate permalink*/
            $(".blog_name").change(function(e) {
                e.preventDefault();
                let name = $(".blog_name").val();
                let permalink = string_to_slug(name);
                $("#permalink").html(permalink);
                $("#permalink_input_field").val(permalink);
                $(".permalink-input-group").removeClass("d-none");
                $(".permalink-editor").addClass("d-none");
                $(".permalink-edit-btn").removeClass("d-none");
            });
            /*edit permalink*/
            $(".permalink-edit-btn").on("click", function(e) {
                e.preventDefault();
                let permalink = $("#permalink").html();
                $("#permalink-updated-input").val(permalink);
                $(".permalink-edit-btn").addClass("d-none");
                $(".permalink-editor").removeClass("d-none");
            });
            /*Cancel permalink edit*/
            $(".permalink-cancel-btn").on("click", function(e) {
                e.preventDefault();
                $("#permalink-updated-input").val();
                $(".permalink-editor").addClass("d-none");
                $(".permalink-edit-btn").removeClass("d-none");
            });
            /*Update permalink*/
            $(".permalink-save-btn").on("click", function(e) {
                e.preventDefault();
                let input = $("#permalink-updated-input").val();
                let updated_permalnk = string_to_slug(input);
                $("#permalink_input_field").val(updated_permalnk);
                $("#permalink").html(updated_permalnk);
                $(".permalink-editor").addClass("d-none");
                $(".permalink-edit-btn").removeClass("d-none");
            });
        })(jQuery);

        // select plugin -- function
        function selectPlugin(element) {
            "use strict";
            $(element).select2({
                theme: "classic",
                placeholder: '{{ translate('No Option Selected') }}',
            });
        }

        // add new buttonn toogle -- function
        function ButtonToggle(button, form) {
            "use strict";
            $(button).on('click', function() {
                $(form).toggleClass('d-none');
            });
        }

        // Blog preview and draft
        function blogPreviewDraft(action) {
            "use strict";
            var formData = $('#blog_form').serializeArray();
            formData.push({
                name: "action",
                value: action
            });

            $.ajax({
                method: 'POST',
                url: '{{ route('core.blog.draft.preview') }}',
                dataType: 'json',
                data: formData
            }).done(function(response) {
                if (response.error) {
                    toastr.error(response.error, "Error!");
                } else {
                    switch (action) {
                        case 'draft':
                            $('#blog_id').val(response.id);
                            toastr.success(response.success, "Success!");
                            break;

                        case 'preview':
                            $('#blog_id').val(response.id);
                            window.open('/blog-preview?name=' + response.permalink);
                            break;

                        case 'pending':
                            $('#blog_id').val(response.id);
                            toastr.info(response.success, "Success!");
                            break;

                        default:
                            toastr.error(response.error, "Error!");
                            break;
                    }
                }
            });
        }

        // send file function summernote
        function sendFile(image, editor, welEditable) {
            "use strict";
            let imageUploadUrl = '{{ route('core.blog.content.image') }}';
            let data = new FormData();
            data.append("image", image);

            $.ajax({
                data: data,
                type: "POST",
                url: imageUploadUrl,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {

                    if (data.url) {
                        var image = $('<img>').attr('src', data.url);
                        $('#blog_content').summernote("insertNode", image[0]);
                    } else {
                        toastr.error(data.error, "Error!");
                    }
                },
                error: function(data) {
                    toastr.error('Image Upload Failed', "Error!");
                }
            });
        }
    </script>
@endsection
