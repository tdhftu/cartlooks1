@extends('core::base.layouts.master')
@section('title')
    {{ translate('Multivendor Updater') }}
@endsection
@section('custom_css')
@endsection
@section('main_content')
    <div class="row">
        <div class="col-md-7 mb-30 mx-auto">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h4>{{ translate('Multivendor Updater') }}</h4>
                </div>
                <div class="card-body">
                    @if ($update_available)
                        <p>{{ translate('Current version') }} {{ $current_version }}</p>
                        <p>{{ translate('Latest version') }} {{ $latest_version }}</p>
                        <form action="{{ route('plugin.multivendor.update') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn long rounded">{{ translate('Update Multivendor Now') }}
                            </button>
                        </form>
                    @else
                        <p>{{ translate('Multivendor is updated') }}</p>
                        <p>{{ translate('Current version') }} {{ $current_version }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
