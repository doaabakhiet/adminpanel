<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'attributes';

    public function info_translations()
    {
        return $this->hasMany(AttributeTranslation::class);
    }
}
