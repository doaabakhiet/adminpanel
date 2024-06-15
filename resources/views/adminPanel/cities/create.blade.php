<!-- Modal -->
<div class="modal fade" id="addcityModal" tabindex="-1" role="dialog" aria-labelledby="addcityModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addcityModalLabel">@lang('lang.add_city')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

              
                <form action="{{ route('cities.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                <div class="form-group">
                    {!! Form::label('title', __('lang.title') . ':*') !!}

                    @include('adminPanel.partials.translation_inputs', [
                        'attribute' => 'title',
                        'translations' => [],
                        'type' => 'city',
                    ])
                </div>
                <div class="form-group">
                    {!! Form::label('area_id', __('lang.area'), ['class'=>'h5 pt-3']) !!}
                    {!! Form::select('area_id', $areas, null, [
                        'class' => 'form-control js-example-basic-single','style'=>"width:100%;",'required'
                    ]) !!}
                  </div>
                  @error('area_id')
                  <span class="text-danger">{{ $message }}</span>
              @enderror




                <div class="form-group">
                    <label>@lang('lang.image')</label>
                    <input type="file" name="image" class="file-upload-default" required>
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled=""
                            placeholder="@lang('lang.upload_image')">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-gradient-primary py-3"
                                type="button">@lang('lang.upload')</button>
                        </span>
                    </div>
                </div>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
         


            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
            </div>
        </form>
        </div>
     
    </div>
</div>
</div>
