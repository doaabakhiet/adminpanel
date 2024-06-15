<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class City extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = ['id'];
    protected $table = 'cities';

    public function city_translations()
    {
        return $this->hasMany(cityTranslation::class);
    }
    public function area(){
        return $this->belongsTo(Area::class,'area_id');
    }
    public function translation($locale)
    {
        return $this->city_translations()->where('locale', $locale)->first();
    }
}
