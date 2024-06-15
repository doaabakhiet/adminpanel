<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class NeighborhoodTranslation extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $timestamps=false;
    public function scopeCurrentLocale($query)
    {
        return $query->where('locale', App::getLocale());
    }
    public function neighborhood(){
        return $this->belongsTo(Neighborhood::class,'neighborhood_id');
    }
}
