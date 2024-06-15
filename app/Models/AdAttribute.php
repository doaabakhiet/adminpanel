<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdAttribute extends Model
{
    use HasFactory;
    protected $fillable = ['ad_id', 'attribute_id', 'value'];
    public $timestamps = false;
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class,'ad_attributes')->withPivot('value');
    }
}
