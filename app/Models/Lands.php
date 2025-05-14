<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lands extends Model
{
    use HasFactory;

    protected $table = 'lands';
    protected $guarded = []; // للسماح لكل الحقول (مع الانتباه للمخاطر الأمنية)


    public function investor()
    {
        return $this->belongsTo(Investors::class, 'investor_id');
    }
    public function attachments()
    {
        return $this->hasMany(Attachments::class, 'land_id');
    }


}
