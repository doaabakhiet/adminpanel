<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function neighborhood_translations()
    {
        return $this->hasMany(NeighborhoodTranslation::class);
    }
}
