<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;
    protected $table = 'attachments';

    protected $fillable = [
        'land_id',
        'file_path',
        'type',
        'original_name',
        'uploaded_by',
    ];

    public function land()
    {
        return $this->belongsTo(Lands::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }


}
