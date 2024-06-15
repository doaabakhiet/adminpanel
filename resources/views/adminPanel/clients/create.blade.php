<!-- Modal -->
<div class="modal fade" id="addclientModal" tabindex="-1" role="dialog" aria-labelledby="addclientModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addclientModalLabel">@lang('lang.add_client')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        {!! Form::label('title', __('lang.title') . ':*') !!}
                        <input class="form-control " type="text" name="title" value=""
                            placeholder="@lang('lang.title')">
                    </div>





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
