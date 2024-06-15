@extends('layouts.app')
@section('title', __('lang.home_page'))
@section('content')
    <div class="content-wrapper">
        {{-- <div class="main-panel"> --}}
        {{-- <div class="content-wrapper"> --}}
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Basic elements</h4>
                        <form class="forms-sample" action="{{ route('settings.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.logo')</label>
                                <input type="file" name="logo" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled=""
                                        placeholder="@lang('lang.upload_image')">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-gradient-primary py-3"
                                            type="button">@lang('lang.upload')</button>
                                    </span>
                                </div>
                            </div>
                            @if(!empty($settings['logo']))
                            <div class="p-3">
                                <img src="{{!empty($settings['logo']) ?asset('storage/' . $settings['logo']):''}}" alt="Image for logo" width="150" height="150">
                            </div>
                            @endif
                            <div class="form-group">
                                <label>@lang('lang.home_page_image')</label>
                                <input type="file" name="home_page_image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled=""
                                        placeholder="@lang('lang.upload_image')">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-gradient-primary py-3"
                                            type="button">@lang('lang.upload')</button>
                                    </span>
                                </div>
                            </div>
                            @if(!empty($settings['home_about_us_image']))
                            <div class="p-3">
                                <img src="{{!empty($settings['home_page_image']) ?asset('storage/' . $settings['home_page_image']):''}}" alt="Image for home page image" width="150" height="150">
                            </div>
                            @endif

                            <div class="form-group">
                                <label for="header_title_ar">@lang('lang.header_title_ar')</label>
                                <input type="text" class="form-control" id="header_title_ar" name="header_title_ar"
                                    placeholder="@lang('lang.header_title_ar')"
                                    value="{{ !empty($settings['header_title_ar']) ? $settings['header_title_ar'] : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="header_title_en">@lang('lang.header_title_en')</label>
                                <input type="text" class="form-control" id="header_title_en" name="header_title_en"
                                    value="{{ !empty($settings['header_title_en']) ? $settings['header_title_en'] : '' }}"
                                    placeholder="@lang('lang.header_title_en')">
                            </div>
                            <div class="form-group">
                                <label for="header_des_ar">@lang('lang.header_des_ar')</label>
                                <textarea class="form-control ckeditor" id="header_des_ar" name="header_des_ar" rows="4">{{ !empty($settings['header_des_ar']) ? $settings['header_des_ar'] : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="header_des_en">@lang('lang.header_des_en')</label>
                                <textarea class="form-control ckeditor" id="header_des_en" name="header_des_en" rows="4">{{ !empty($settings['header_des_en']) ? $settings['header_des_en'] : '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="address_ar">@lang('lang.address_ar')</label>
                                <textarea class="form-control ckeditor" id="address_ar" name="address_ar" rows="4"> {{ !empty($settings['address_ar']) ? $settings['address_ar'] : '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="address_en">@lang('lang.address_en')</label>
                                <textarea class="form-control ckeditor" id="address_en" name="address_en" rows="4">{{ !empty($settings['address_en']) ? $settings['address_en'] : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="business_days_ar">@lang('lang.business_days_ar')</label>
                                <input type="text" class="form-control" id="business_days_ar" name="business_days_ar"
                                    placeholder="@lang('lang.business_days_ar')"
                                    value="{{ !empty($settings['business_days_ar']) ? $settings['business_days_ar'] : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="business_days_en">@lang('lang.business_days_en')</label>
                                <input type="text" class="form-control" id="business_days_en" name="business_days_en"
                                    placeholder="@lang('lang.business_days_en')"
                                    value="{{ !empty($settings['business_days_en']) ? $settings['business_days_en'] : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="footer_title_ar">@lang('lang.footer_title_ar')</label>
                                <input type="text" class="form-control" id="footer_title_ar" name="footer_title_ar"
                                    value="{{ !empty($settings['footer_title_ar']) ? $settings['footer_title_ar'] : '' }}"
                                    placeholder="@lang('lang.footer_title_ar')">
                            </div>
                            <div class="form-group">
                                <label for="footer_title_en">@lang('lang.footer_title_en')</label>
                                <input type="text" class="form-control" id="footer_title_en" name="footer_title_en"
                                    value="{{ !empty($settings['footer_title_en']) ? $settings['footer_title_en'] : '' }}"
                                    placeholder="@lang('lang.footer_title_en')">
                            </div>
                            <div class="form-group">
                                <label for="footer_des_ar">@lang('lang.footer_des_ar')</label>
                                <textarea class="form-control ckeditor" id="footer_des_ar" name="footer_des_ar" rows="4"> {{ !empty($settings['footer_des_ar']) ? $settings['footer_des_ar'] : '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="footer_des_en">@lang('lang.footer_des_en')</label>
                                <textarea class="form-control ckeditor" id="footer_des_en" name="footer_des_en" rows="4"> {{ !empty($settings['footer_des_en']) ? $settings['footer_des_en'] : '' }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 grid-margin">
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-6 col-form-label">@lang('lang.email')</label>
                                        <input type="text" name="email" class="form-control"
                                            {{ !empty($settings['email']) ? $settings['email'] : '' }}
                                            placeholder="@lang('lang.email')">
                                    </div>
                                </div>
                                <div class="col-md-6 grid-margin">
                                    <div class="form-group row">
                                        <label for="watsapp" class="col-sm-6 col-form-label">@lang('lang.watsapp')</label>
                                        <input type="text" name="watsapp" class="form-control"
                                            value="{{ !empty($settings['watsapp']) ? $settings['watsapp'] : '' }}"
                                            placeholder="@lang('lang.watsapp')">
                                    </div>
                                </div>
                                <div class="col-md-6 grid-margin">
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-6 col-form-label">@lang('lang.phone')</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ !empty($settings['phone']) ? $settings['phone'] : '' }}"
                                            placeholder="@lang('lang.phone')">
                                    </div>
                                </div>
                                <div class="col-md-6 grid-margin">
                                    <div class="form-group row">
                                        <label for="second_phone"
                                            class="col-sm-6 col-form-label">@lang('lang.phone')2</label>
                                        <input type="text" name="second_phone" class="form-control"
                                            value="{{ !empty($settings['phone2']) ? $settings['phone2'] : '' }}"
                                            placeholder="@lang('lang.phone')2">
                                    </div>
                                </div>
                            </div>

                            <h4>@lang('lang.contacts')</h4>
                            <div id="add-row" class="btn btn-primary"><i class="fa fa-add"></i>@lang('lang.add')</div>
                            <div id="container">
                                @foreach ($icons as $index => $icon)
                                <div class="row" id="row-{{ $index }}">
                                    <div class="col-md-5 grid-margin">
                                        <input type="hidden" name="icons[{{ $index }}][id]" value="{{$icon->id}}"/>
                                        <div class="form-group row">
                                            <label for="icons-{{ $index }}-title" class="col-sm-6 col-form-label">@lang('lang.media_name')</label>
                                            <input type="text" id="icons-{{ $index }}-title" name="icons[{{ $index }}][title]" class="form-control"
                                                   value="{{$icon->title}}" placeholder="@lang('lang.media_name')">
                                        </div>
                                    </div>
                                    <div class="col-md-5 grid-margin">
                                        <div class="form-group row">
                                            <label for="icons-{{ $index }}-url" class="col-sm-6 col-form-label">@lang('lang.url')</label>
                                            <input type="text" id="icons-{{ $index }}-url" name="icons[{{ $index }}][url]" class="form-control"
                                                   value="{{$icon->link}}" placeholder="@lang('lang.url')">
                                        </div>
                                    </div>
                                    <div class="col-md-1 grid-margin text-center">
                                        <div class="form-group row pt-5">
                                            <div class="remove-row btn btn-danger btn-sm" data-row-id="row-{{ $index }}"><i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            </div>

                            <br>
                            <br>
                            <h4 class="card-title">@lang('lang.home_about_us')</h4>
                            <div class="form-group">
                                <label for="home_about_us_ar">@lang('lang.home_about_us_ar')</label>
                                <textarea class="form-control ckeditor" id="home_about_us_ar" name="home_about_us_ar" rows="4"> {{ !empty($settings['home_about_us_ar']) ? $settings['home_about_us_ar'] : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="home_about_us_en">@lang('lang.home_about_us_en')</label>
                                <textarea class="form-control ckeditor" id="home_about_us_en" name="home_about_us_en" rows="4"> {{ !empty($settings['home_about_us_en']) ? $settings['home_about_us_en'] : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.home_about_us_image')</label>
                                <input type="file" name="home_about_us_image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled=""
                                        placeholder="@lang('lang.upload_image')">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-gradient-primary py-3"
                                            type="button">@lang('lang.upload')</button>
                                    </span>
                                </div>
                            </div>
                            @if(!empty($settings['home_about_us_image']))
                            <div class="p-3">
                            <img src="{{!empty($settings['home_about_us_image']) ?asset('storage/' . $settings['home_about_us_image']):''}}" alt="Image for home about us image" width="150" height="150">
                            </div>
                            @endif

                            <button type="submit" class="btn btn-gradient-primary me-2">@lang('lang.save')</button>
                        </form>
                    </div>
                    {{-- </div> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            let rowCounter = {{ count($icons) }}; // Initialize rowCounter with the number of existing rows

$('#add-row').on('click', function() {
    rowCounter++;
    let newRow = `
        <div class="row" id="row-${rowCounter}">
            <div class="col-md-5 grid-margin">
                <div class="form-group row">
                    <label for="icons-${rowCounter}-title" class="col-sm-6 col-form-label">@lang('lang.media_name')</label>
                    <input type="text" id="icons-${rowCounter}-title" name="icons[${rowCounter}][title]" class="form-control" placeholder="@lang('lang.media_name')">
                </div>
            </div>
            <div class="col-md-5 grid-margin">
                <div class="form-group row">
                    <label for="icons-${rowCounter}-url" class="col-sm-6 col-form-label">@lang('lang.url')</label>
                    <input type="text" id="icons-${rowCounter}-url" name="icons[${rowCounter}][url]" class="form-control" placeholder="@lang('lang.url')">
                </div>
            </div>
            <div class="col-md-1 grid-margin text-center">
                <div class="form-group row pt-5">
                    <div class="remove-row btn btn-danger btn-sm" data-row-id="row-${rowCounter}"><i class="fa fa-trash"></i></div>
                </div>
            </div>
        </div>
    `;
    $('#container').prepend(newRow);
});

// Handle removing rows
$(document).on('click', '.remove-row', function() {
    let rowId = $(this).data('row-id');
    $('#' + rowId).remove();
});

            // Event delegation for dynamically added elements
            // $('#container').on('click', '.remove-row', function(event) {
            //     event.preventDefault();
            //     let rowId = $(this).data('row-id');
            //     $('#' + rowId).remove();
            // });
        });
    </script>
@endpush
