@extends('layouts.app')
@section('title', __('lang.contact_us'))
@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang('lang.contact_us')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 class="text-primary">@lang('lang.name'):</h5>
                                {{ $contact->name }}
                            </div>
                            <br>
                            <div class="col-sm-12">
                                <h5 class="text-primary">@lang('lang.phone'):</h5>
                                {{ $contact->phone }}
                            </div>
                            <br>
                            <div class="col-sm-12">
                                <h5 class="text-primary">@lang('lang.email'):</h5>
                                {{ $contact->email }}
                            </div>
                            <br>
                            <div class="col-sm-12">
                                <h5 class="text-primary">@lang('lang.message'):</h5>
                                {!! $contact->message !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
