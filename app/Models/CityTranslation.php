<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CityTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['city_id', 'locale', 'title'];
    public $timestamps=false;
    protected $table = 'city_translations';
    public function scopeCurrentLocale($query)
    {
        return $query->where('locale', App::getLocale());
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }
}
