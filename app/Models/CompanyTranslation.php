<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CompanyTranslation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps=false;
    protected $table = 'company_translations';
    public function scopeCurrentLocale($query)
    {
        return $query->where('locale', App::getLocale());
    }
}
