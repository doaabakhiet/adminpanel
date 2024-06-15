<?php

use App\Models\Area;
use App\Models\City;
use Illuminate\Support\Facades\Storage;

function store_file($file, $path)
{
    $name = time() . $file->getClientOriginalName();
    return $value = $file->storeAs($path, $name, 'uploads');
}
function delete_file($file)
{
    if ($file != '' and !is_null($file) and Storage::disk('uploads')->exists($file)) {
        unlink('uploads/' . $file);
    }
}
function display_file($name)
{
    return asset('uploads') . '/' . $name;
}

function num_uf($input_number, $currency_details = null)
{
    $thousand_separator  = ',';
    $decimal_separator  = '.';
    $num = str_replace($thousand_separator, '', $input_number);
    $num = str_replace($decimal_separator, '.', $num);
    return (float)$num;
}

function getTranslatedAreaTitle($areaId, $locale = 'en')
{
    $area = Area::find($areaId);

    if ($area) {
        $translation = $area->translation($locale);
        return $translation ;
    }

    return null;
}

function getTranslatedTitle($cityId, $locale = 'en')
{
    $city = City::find($cityId);

    if ($city) {
        $city_translation = $city->translation($locale);
        return ($city_translation->title??'').'/' .getTranslatedAreaTitle( $city_translation->city->area_id, app()->getLocale())  ;
    }

    return null;
}
