<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;
    protected $table = 'attachments';

    protected $fillable = [
        'reference_type',
        'reference_id_fk',
        'attachment_type_cd',
        'created_by',
        'file_type',
        'file_path',
        'original_name',
        'file_description',
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
