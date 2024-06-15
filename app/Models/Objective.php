<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    use HasFactory;
    use HasFactory;
    protected $guarded = [];
    public function objective_translations()
    {
        return $this->hasMany(ObjectiveTranslation::class);
    }
}
