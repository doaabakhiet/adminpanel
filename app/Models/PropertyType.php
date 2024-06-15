<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'property_types';

    public function property_type_translations()
    {
        return $this->hasMany(PropertyTypeTranslation::class);
    }
}
