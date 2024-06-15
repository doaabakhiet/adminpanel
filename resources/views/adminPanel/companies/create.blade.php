<!-- Modal -->
<div class="modal fade" id="addcompanyModal" tabindex="-1" role="dialog" aria-labelledby="addcompanyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addcompanyModalLabel">@lang('lang.add_company')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

              
                <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                <div class="form-group">
                    {!! Form::label('title', __('lang.title') . ':*') !!}

                    @include('adminPanel.partials.translation_inputs', [
                        'attribute' => 'title',
                        'translations' => [],
                        'type' => 'company',
                    ])
                </div>

                <div class="form-group">
                    {!! Form::label('description', __('lang.description') . ':') !!}

                    @include('adminPanel.partials.translation_textarea', [
                        'attribute' => 'description',
                        'translations' => [],
                        'type' => 'company',
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
