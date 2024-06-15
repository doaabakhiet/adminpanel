<!-- Modal -->
<div class="modal fade" id="addproperty_typeModal" tabindex="-1" role="dialog" aria-labelledby="addproperty_typeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addproperty_typeModalLabel">@lang('lang.add_property_type')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <form action="{{ route('property_type.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        {!! Form::label('title', __('lang.title') . ':*') !!}
    
                        @include('adminPanel.partials.translation_inputs', [
                            'attribute' => 'title',
                            'translations' => [],
                            'type' => 'ojective',
                        ])
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
