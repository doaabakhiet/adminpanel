@extends('layouts.app')
@section('title', __('lang.add_info'))
@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang('lang.add_info')</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('infos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 grid-margin">
                                    <div class="form-group row">
                                        <label for="type" class="col-sm-3 col-form-label">@lang('lang.type')</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="type" name="type"
                                                placeholder="@lang('lang.type')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 grid-margin">
                                    <div class="form-group row">
                                        <label for="sort" class="col-sm-3 col-form-label">@lang('lang.sort')</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="sort" name="sort"
                                                placeholder="@lang('lang.sort')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('title', __('lang.title') . ':*') !!}

                                @include('adminPanel.partials.translation_inputs', [
                                    'attribute' => 'title',
                                    'translations' => [],
                                    'type' => 'info',
                                ])
                            </div>

                            <div class="form-group">
                                {!! Form::label('description', __('lang.description') . ':') !!}

                                @include('adminPanel.partials.translation_textarea', [
                                    'attribute' => 'description',
                                    'translations' => [],
                                    'type' => 'info',
                                ])
                            </div>



                            <div class="form-group">
                                <label>@lang('lang.image')</label>
                                <input type="file" name="image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled=""
                                        placeholder="@lang('lang.upload_image')">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-gradient-primary py-3"
                                            type="button">@lang('lang.upload')</button>
                                    </span>
                                </div>
                            </div>





                            <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
