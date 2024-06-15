<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">@lang('lang.edit_client')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => ['property_type.update', $property_type->id],
                'method' => 'put',
                'id' => 'property_type-update-form',
                'enctype' => 'multipart/form-data',
            ]) !!}

                @csrf
                @method('PUT')
                @php
                    $config_langs = config('constants.langs');
                @endphp
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('title', __('lang.title') . ':*') !!}
                        <div class="row">
                            <div class="col-md-12">
                                @foreach ($property_type->property_type_translations as $key => $lang)
                                    <input class="form-control translations" type="hidden"
                                        name="translations[id][{{ $lang->locale }}]" value="{{ $lang->id ?? '' }}">
                                    <input class="form-control translations" type="text"
                                        name="translations[title][{{ $lang->locale }}]" value="{{ $lang->title ?? '' }}"
                                        placeholder="{{ $config_langs[$lang->locale]['full_name'] }}">
                                @endforeach
    
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()"
                        data-dismiss="modal">@lang('lang.close')</button>
                    <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                </div>
                {!! Form::close() !!}
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/file-upload.js') }}"></script>
