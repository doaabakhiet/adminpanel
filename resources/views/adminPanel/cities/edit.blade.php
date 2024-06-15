<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">@lang('lang.edit_city')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => ['cities.update', $city->id], 'method' => 'put', 'id' => 'city-update-form', 'enctype' => 'multipart/form-data']) !!}

            <form action="{{ route('cities.update',$city->id) }}" method="put" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                @php
                    $config_langs = config('constants.langs');
                @endphp
                <div class="form-group">
                    {!! Form::label('title', __('lang.title') . ':*') !!}
                    <div class="row">
                        <div class="col-md-12">
                            @foreach ($city->city_translations as $key => $lang)
                                <input class="form-control translations" type="hidden"
                                    name="translations[id][{{ $lang->locale }}]" value="{{ $lang->id ?? '' }}">
                                <input class="form-control translations" type="text"
                                    name="translations[title][{{ $lang->locale }}]" value="{{ $lang->title ?? '' }}"
                                    placeholder="{{ $config_langs[$lang->locale]['full_name'] }}">
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('area_id', __('lang.area'), ['class'=>'h5 pt-3']) !!}
                    {!! Form::select('area_id', $areas, $city->area_id, [
                        'class' => 'form-control js-example-basic-single','style'=>"width:100%;",'required'
                    ]) !!}
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
                        $image = App\Models\City::find($city->id)->getFirstMediaUrl('images');
                    @endphp

                    <img src="{{ $image }}" alt="Image for city" width="300" height="200">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">@lang('lang.close')</button>
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/file-upload.js') }}"></script>

