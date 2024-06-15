<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Ad extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = ['id'];
    protected $appends=['min_image'];

    public function ad_translations()
    {
        return $this->hasMany(AdTranslation::class);
    }
    public function getMinImageAttribute()
    {
        return   $this->getFirstMediaUrl('min_image')?:'';

    }
    public function scopeSpecial(Builder $query)
    {
        $query->where('is_special',1);
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class,'ad_attributes')->withPivot('value');
    }
}
