@extends('core::base.layouts.master')

@section('title')
    {{ translate('Edit Blog Category') }}
@endsection

@section('custom_css')
@endsection

@section('main_content')
    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div class="row">
                <div class="col-12 mb-3">
                    <p class="alert alert-info">You are editing <strong>"{{ getLanguageNameByCode($lang) }}"</strong> version
                    </p>
                </div>
            </div>
            <div class="card mb-30">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4>{{ translate('Edit Blog Category') }}</h4>
                    <a href="{{ route('core.add.blog.category') }}" class="btn long ">{{ translate('Add New Category') }}</a>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <ul class="nav nav-tabs nav-fill border-light border-0">
                            @foreach ($languages as $key => $language)
                                <li class="nav-item">
                                    <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-3"
                                        href="{{ route('core.edit.blog.category', ['id' => $bcategory->id, 'lang' => $language->code]) }}">
                                        <img src="{{ asset('/public/web-assets/backend/img/flags/') . '/' . $language->code . '.png' }}"
                                            width="20px">
                                        <span>{{ $language->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <form class="form-horizontal mt-4" action="{{ route('core.update.blog.category') }}" method="post">
                        @csrf

                        {{-- Category - Name Field --}}
                        <input type="hidden" name="id" value="{{ $bcategory->id }}">
                        <input type="hidden" name="lang" value="{{ $lang }}">

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 font-14 bold black">{{ translate('Name') }} <span
                                    class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="name"
                                    class="form-control @if (!empty($lang) && $lang == getdefaultlang()) category_name @endif"
                                    value="{{ $bcategory->translation('name', $lang) }}"
                                    placeholder="{{ translate('Name') }}">
                                <input type="hidden" name="permalink" id="permalink_input_field"
                                    value="{{ $bcategory->permalink }}">

                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>
                        {{-- Category - Name Field --}}

                        {{-- Permalink --}}
                        <div
                            class="form-row mb-20 permalink-input-group @if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Permalink') }} </label>
                            </div>
                            <div class="col-sm-8">
                                <a href="#">{{ url('') }}/blog/category/<span
                                        id="permalink">{{ $bcategory->permalink }}</span><span
                                        class="btn custom-btn ml-1 permalink-edit-btn">{{ translate('Edit') }}</span></a>
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
                        {{-- Permalink End --}}

                        {{-- Parent --}}
                        <div class="form-row mb-20 @if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Parent') }}</label><span
                                    class="text-danger"> *</span>
                            </div>
                            <div class="col-sm-8">
                                <select class="parentCategorySelect form-control" name="parent"
                                    value="{{ $bcategory->parent }}" placeholder="{{ translate('Select a Category') }}">
                                    @if ($bcategory->parent == null)
                                        <option value="">
                                            {{ translate('Select a Category') }}
                                        </option>
                                    @endif
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $bcategory->parent == $category->id ? 'selected' : '' }}>
                                            {{ $category->translation('name', getLocale()) }}
                                        </option>
                                        @if (count($category->childs))
                                            @include('core::base.blog.includes.blog_child_category', [
                                                'child_category' => $category->childs,
                                                'label' => 1,
                                                'parent' => $bcategory->parent,
                                                'active_childs' => false,
                                            ])
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('parent'))
                                    <div class="invalid-input">{{ $errors->first('parent') }}</div>
                                @endif
                            </div>
                        </div>
                        {{-- Parent End --}}

                        {{-- Short Description --}}
                        <div class="form-row mb-20">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Short Description') }} </label>
                            </div>
                            <div class="col-sm-8">
                                <textarea name="short_description" class="theme-input-style h-100"> {{ $bcategory->translation('short_description', $lang) }}</textarea>
                                @if ($errors->has('short_description'))
                                    <div class="invalid-input">{{ $errors->first('short_description') }}</div>
                                @endif
                            </div>
                        </div>
                        {{-- Short Description End --}}

                        {{-- Seo --}}
                        <div class="form-row mb-20 @if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Meta Title') }} </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="meta_title" class="theme-input-style"
                                    value="{{ $bcategory->meta_title }}" placeholder="{{ translate('Type here') }}">
                                @if ($errors->has('meta_title'))
                                    <div class="invalid-input">{{ $errors->first('meta_title') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-row mb-20 @if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Meta Image') }} </label>
                            </div>
                            <div class="col-sm-8">
                                @include('core::base.includes.media.media_input', [
                                    'input' => 'meta_image',
                                    'data' => $bcategory->meta_image,
                                ])
                                @if ($errors->has('meta_image'))
                                    <div class="invalid-input">{{ $errors->first('meta_image') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-row mb-20 @if (!empty($lang) && $lang != getdefaultlang()) area-disabled @endif">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Meta Description') }} </label>
                            </div>
                            <div class="col-sm-8">
                                <textarea name="meta_description" class="theme-input-style"> {{ $bcategory->meta_description }}</textarea>
                                @if ($errors->has('meta_description'))
                                    <div class="invalid-input">{{ $errors->first('meta_description') }}</div>
                                @endif
                            </div>
                        </div>
                        {{-- Seo End --}}

                        <div class="form-group row">
                            <div class="offset-sm-4 col-sm-8">
                                <button type="submit" class="btn long">{{ translate('Update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('core::base.media.partial.media_modal')

    <!-- End Main Content -->
@endsection

@section('custom_scripts')
    <script src="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone()
            $(document).ready(function() {
                is_for_browse_file = true
                filtermedia()
            });
            /*Generate permalink*/
            $('.category_name').change(function(e) {
                e.preventDefault();
                let name = $('.category_name').val();
                let permalink = string_to_slug(name);
                $('#permalink').html(permalink);
                $('#permalink_input_field').val(permalink);
                $('.permalink-input-group').removeClass("d-none");
                $('.permalink-editor').addClass("d-none");
                $('.permalink-edit-btn').removeClass("d-none");

            });
            /*edit permalink*/
            $('.permalink-edit-btn').on('click', function(e) {
                e.preventDefault();
                let permalink = $('#permalink').html();
                $('#permalink-updated-input').val(permalink);
                $('.permalink-edit-btn').addClass("d-none");
                $('.permalink-editor').removeClass("d-none");


            });
            /*Cancel permalink edit*/
            $('.permalink-cancel-btn').on('click', function(e) {
                e.preventDefault();
                $('#permalink-updated-input').val();
                $('.permalink-editor').addClass("d-none");
                $('.permalink-edit-btn').removeClass("d-none");

            });
            /*Update permalink*/
            $('.permalink-save-btn').on('click', function(e) {
                e.preventDefault();
                let input = $('#permalink-updated-input').val();
                let updated_permalnk = string_to_slug(input);
                $('#permalink_input_field').val(updated_permalnk);
                $('#permalink').html(updated_permalnk);
                $('.permalink-editor').addClass("d-none");
                $('.permalink-edit-btn').removeClass("d-none");

            });
        })(jQuery);
    </script>
@endsection
