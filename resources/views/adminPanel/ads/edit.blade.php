@extends('layouts.app')
@section('title', __('lang.edit_ad'))
@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang('lang.edit_ad')</h4>
                    </div>
                    @php
                        $config_langs = config('constants.langs');
                    @endphp
                    <div class="card-body">
                            {!! Form::open([
                                'route' => ['ads.update', $ad->id],
                                'method' => 'put',
                                'id' => 'ads-update-form',
                                'enctype' => 'multipart/form-data',
                            ]) !!}
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                {!! Form::label('title', __('lang.title') . ':*') !!}

                                @foreach ($ad->ad_translations as $key => $lang)
                                    <input class="form-control translations" type="hidden"
                                        name="translations[id][{{ $lang->locale }}]" value="{{ $lang->id ?? '' }}">
                                    <input class="form-control translations" type="text"
                                        name="translations[title][{{ $lang->locale }}]" value="{{ $lang->title ?? '' }}"
                                        placeholder="{{ $config_langs[$lang->locale]['full_name'] }}">
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-6 grid-margin">
                                    <div class="form-group row">
                                        {!! Form::label('city_id', __('lang.city'), ['class' => 'h5 pt-3']) !!}
                                        {!! Form::select('city_id', $cities, $ad->city_id ?? null, [
                                            'class' => 'form-control js-example-basic-single',
                                            'style' => 'width:100%;',
                                            'required',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 grid-margin">
                                    <div class="form-group row">
                                        {!! Form::label('neighborhood_id', __('lang.neighborhood'), ['class' => 'h5 pt-3']) !!}
                                        {!! Form::select('neighborhood_id', $neighborhoods, $ad->neighborhood_id ?? null, [
                                            'class' => 'form-control js-example-basic-single',
                                            'style' => 'width:100%;',
                                            'required',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 grid-margin">
                                    <div class="form-group row">
                                        <label for="price" class="col-sm-3 col-form-label">@lang('lang.price')</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="price" name="price"
                                                value="{{ $ad->price ?? '' }}" placeholder="@lang('lang.price')">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input"
                                                    {{ $ad->is_special == 1 ? 'checked' : '' }} name="is_special"
                                                    value="1">@lang('lang.is_special') <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('property_type_id', __('lang.property_type'), ['class' => 'h5 pt-3']) !!}
                                        {!! Form::select('property_type_id', $property_types, $ad->property_type_id ?? null, [
                                            'class' => 'form-control js-example-basic-single',
                                            'style' => 'width:100%;',
                                            'required',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('category_id', __('lang.category'), ['class' => 'h5 pt-3']) !!}
                                        {!! Form::select('category_id', $categories, $ad->category_id ?? null, [
                                            'class' => 'form-control js-example-basic-single',
                                            'style' => 'width:100%;',
                                            'required',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('company_id', __('lang.company'), ['class' => 'h5 pt-3']) !!}
                                        {!! Form::select('company_id', $companies, $ad->company_id ?? null, [
                                            'class' => 'form-control js-example-basic-single',
                                            'style' => 'width:100%;',
                                            'required',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('attribute_id', __('lang.attribute'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::select('attribute_id', $attributes, $ad->attributes->pluck('pivot.attribute_id')->toArray(), [
                                    'class' => 'form-control js-example-basic-multiple',
                                    'style' => 'width:100%;',
                                    'multiple' => 'multiple',
                                    'required',
                                ]) !!}
                            </div>
                            <!-- Container for dynamic text inputs -->
                            <div id="dynamic-inputs-container" class="row">
                                @foreach ($attributesData as $attribute)
                                    <div
                                        class="col-md-12 grid-margin {{ in_array($attribute->attribute_id, $ad->attributes->pluck('pivot.attribute_id')->toArray()) ? '':'d-none'}} toggle-element toggle-element{{ $attribute->attribute_id }}">
                                        <div class="form-group row">
                                            <label for="attribute{{ $attribute->attribute_id }}"
                                                class="col-sm-3 col-form-label text-primary">{{ $attribute->title }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control attribute{{ $attribute->title }}"
                                                    id="attribute{{ $attribute->attribute_id }}"
                                                    name="attributes[{{ $attribute->attribute_id }}]"
                                                    value="{{ in_array($attribute->attribute_id, $ad->attributes->pluck('pivot.attribute_id')->toArray()) ? App\Models\AdAttribute::where('attribute_id',$attribute->attribute_id)->where('ad_id',$ad->id)->first()->value:old('attributes.' . $attribute->attribute_id) }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                            <div class="form-group">
                                {!! Form::label('description', __('lang.description') . ':') !!}
                                @foreach ($ad->ad_translations as $key => $lang)
                                    <textarea class="form-control translations ckeditor" name="translations[description][{{ $lang->locale }}]" value=""
                                        placeholder="{{ $config_langs[$lang->locale]['full_name'] }}">{{ $lang->description ?? '' }}</textarea>
                                @endforeach
                            </div>


                            <div class="form-group">
                                <label>@lang('lang.min_image')</label>
                                <input type="file" name="min_image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-ad" disabled=""
                                        placeholder="@lang('lang.upload_image')">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-gradient-primary py-3"
                                            type="button">@lang('lang.upload')</button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.images')</label>
                                <input type="file" name="images[]" class="file-upload-default" multiple>
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-ad" disabled=""
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
@push('js')
    <script>
        // $(document).ready(function() {
        $(document).on('click', '.select2-selection__rendered,.select2-selection__choice', function(e) {
            e.preventDefault();
            setTimeout(() => {
                let container = $('#dynamic-inputs-container');
                let id = $('.js-example-basic-multiple').val();
                $('.toggle-element').addClass('d-none');
                for (var i = 0; i < id.length; i++) {
                    $('.toggle-element' + id[i]).removeClass('d-none');
                    // $('#attribute'+ id[i]).val('');
                }
            }, 2000);
        });

        $(document).on('click', '.select2-selection__choice', function(e) {
            e.preventDefault();
            setTimeout(() => {
                let element = $(this).attr('title');
                console.log(element)
                $('.attribute' + element).val('');
            }, 2000);
        });
    </script>
@endpush
