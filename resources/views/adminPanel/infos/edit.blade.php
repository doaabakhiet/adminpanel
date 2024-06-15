@extends('layouts.app')
@section('title', __('lang.edit_info'))
@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang('lang.edit_info')</h4>
                    </div>
                    @php
                        $config_langs = config('constants.langs');
                    @endphp
                    <div class="card-body">
                        {!! Form::open([
                            'route' => ['infos.update', $info->id],
                            'method' => 'put',
                            'id' => 'info-update-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
            
                        @csrf
                        @method('PUT')
                            <div class="row">
                                <div class="col-md-6 grid-margin">
                                    <div class="form-group row">
                                        <label for="type" class="col-sm-3 col-form-label">@lang('lang.type')</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="type" name="type"
                                                value="{{ $info->type }}" placeholder="@lang('lang.type')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 grid-margin">
                                    <div class="form-group row">
                                        <label for="sort" class="col-sm-3 col-form-label">@lang('lang.sort')</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="sort" name="sort"
                                                value="{{ $info->sort }}" placeholder="@lang('lang.sort')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('title', __('lang.title') . ':*') !!}
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach ($info->info_translations as $key => $lang)
                                            <input class="form-control translations" type="hidden"
                                                name="translations[id][{{ $lang->locale }}]" value="{{ $lang->id ?? '' }}">
                                            <input class="form-control translations" type="text"
                                                name="translations[title][{{ $lang->locale }}]"
                                                value="{{ $lang->title ?? '' }}"
                                                placeholder="{{ $config_langs[$lang->locale]['full_name'] }}">
                                        @endforeach

                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                {!! Form::label('description', __('lang.description') . ':') !!}
                                @foreach ($info->info_translations as $key => $lang)
                                    <textarea class="form-control translations ckeditor" name="translations[description][{{ $lang->locale }}]" value=""
                                        placeholder="{{ $config_langs[$lang->locale]['full_name'] }}">{{ $lang->description ?? '' }}</textarea>
                                @endforeach
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

                            <div>
                                @php
                                    $image = App\Models\Info::find($info->id)->getFirstMediaUrl('images');
                                @endphp

                                <img src="{{ $image }}" alt="Image for info" width="300" height="200">
                            </div>



                            <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
