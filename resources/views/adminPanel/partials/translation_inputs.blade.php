@php
$config_langs = config('constants.langs');
@endphp
<div class="row">
<div class="col-md-12">

        @foreach ($config_langs as $key => $lang)
          
                    <input class="form-control translations" type="text" required name="translations[{{ $attribute }}][{{ $key }}]"
                        value="@if (!empty($translations[$attribute][$key])) {{ $translations[$attribute][$key] }} @endif"
                        placeholder="{{ $lang['full_name'] }}">
        @endforeach
  
</div>
</div>