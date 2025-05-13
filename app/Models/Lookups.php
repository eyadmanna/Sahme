<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lookups extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "lookups";
    protected $primaryKey = "id";
    protected $guarded = [];
    public function children()
    {
        return $this->hasMany(Lookups::class, "parent_id", "id")->where("status",1);
        }
}
