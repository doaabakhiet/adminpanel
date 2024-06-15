<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">@lang('lang.update')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => ['subscriptions.update', $subscription->id],
                'method' => 'put',
                'id' => 'subscription-update-form',
                'enctype' => 'multipart/form-data',
            ]) !!}

            @csrf
            @method('PUT')
            <div class="modal-body">
       
                <div class="form-group">
                    {!! Form::label('email', __('lang.email') . ':*') !!}

                    <input class="form-control" type="email" name="email" value="{{$subscription->email}}"
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

                <div>
                    @php
                        $image = App\Models\Subscription::find($subscription->id)->getFirstMediaUrl('images');
                    @endphp

                    <img src="{{ $image }}" alt="Image for city" width="300" height="200">
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
