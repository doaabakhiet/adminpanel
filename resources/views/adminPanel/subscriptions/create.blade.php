<!-- Modal -->
<div class="modal fade" id="addsubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="addojectiveModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addojectiveModalLabel">@lang('lang.add')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subscriptions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        {!! Form::label('email', __('lang.email') . ':*') !!}

                        <input class="form-control" type="email" name="email" value=""
                            placeholder="{{ __('lang.email') }}">
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

