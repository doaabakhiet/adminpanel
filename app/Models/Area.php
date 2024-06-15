<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Area extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = [];
    public function area_translations()
    {
        return $this->hasMany(AreaTranslation::class);
    }
    public function translation($locale)
    {
        return $this->area_translations()->where('locale', $locale)->first()->title??'';
    }
}
