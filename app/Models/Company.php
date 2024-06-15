<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Company extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = ['id'];
    protected $table = 'companies';

    public function company_translations()
    {
        return $this->hasMany(CompanyTranslation::class);
    }

    public function translation($locale)
    {
        return $this->company_translations()->where('locale', $locale)->first();
    }
}
