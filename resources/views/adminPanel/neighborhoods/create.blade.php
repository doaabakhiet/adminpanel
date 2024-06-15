<!-- Modal -->
<div class="modal fade" id="addneighborhoodModal" tabindex="-1" role="dialog" aria-labelledby="addneighborhoodModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addneighborhoodModalLabel">@lang('lang.add_neighborhood')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

              
                <form action="{{ route('neighborhoods.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                <div class="form-group">
                    {!! Form::label('title', __('lang.title') . ':*') !!}

                    @include('adminPanel.partials.translation_inputs', [
                        'attribute' => 'title',
                        'translations' => [],
                        'type' => 'neighborhood',
                    ])
                </div>

                <div class="form-group">
                    {!! Form::label('city_id', __('lang.city'), ['class'=>'h5 pt-3']) !!}
                    {!! Form::select('city_id', $cities, null, [
                        'class' => 'form-control js-example-basic-single','style'=>"width:100%;",'required'
                    ]) !!}
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
