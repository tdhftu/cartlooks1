@extends('core::base.layouts.master')
@section('title')
    {{ translate('User Information') }}
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.css') }}">
@endsection
@section('main_content')
    <div class="row">
        <div class="col-md-7 mx-auto mb-30">
            <!-- Add new user-->
            <div class="card">
                <div class="card-header bg-white border-bottom2 py-3">
                    <h4 class="mb-1">{{ translate('User Information') }}</h4>
                </div>
                <div class="card-body">
                    <div>
                        <form action="{{ route('core.update.user') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Profile Picture') }}</label>
                                </div>
                                <div class="col-md-8">
                                    @include('core::base.includes.media.media_input', [
                                        'input' => 'pro_pic',
                                        'data' => $user->pro_pic,
                                    ])
                                    @if ($errors->has('pro_pic'))
                                        <div class="invalid-input">{{ $errors->first('pro_pic') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Name') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name" class="theme-input-style"
                                        value="{{ $user->name }}" placeholder="{{ translate('Give your name') }}">
                                    @if ($errors->has('name'))
                                        <div class="invalid-input">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-sm-4">
                                    <label class="font-14 bold black">{{ translate('Email') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" name="email" class="theme-input-style"
                                        value="{{ $user->email }}"
                                        placeholder="{{ translate('Give your email address') }}">
                                    @if ($errors->has('email'))
                                        <div class="invalid-input">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Assign Role') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <select id='select_roles' name="role[]" class="theme-input-style" multiple>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected($user_roles->contains('role_id', $role->id))>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('role'))
                                        <div class="invalid-input">{{ $errors->first('role') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Status') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <label class="switch glow primary medium">
                                        <input type="checkbox" {{ $user->status == 1 ? 'checked' : '' }} name="status">
                                        <span class="control"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn long">{{ translate('Save Changes') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Add new user-->
            @include('core::base.media.partial.media_modal')
        </div>
    </div>
@endsection
@section('custom_scripts')
    <script src="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone();

            $(document).ready(function() {
                $('#select_roles').select2({
                    theme: "classic",
                    placeholder: "{{ translate('Select a Role') }}"
                });
            });
        })(jQuery);
    </script>
@endsection
