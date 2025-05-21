<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investors extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'investors';
    
    protected $guarded='';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected static function booted()
    {

        static::creating(function ($model) {
            $model->markAsPending();
        });
    }

 public function statusLookup()
    {
        return $this->belongsTo(Lookups::class, 'status_cd', 'id')
                   ->where('master_key', 'investor_status');
    }

    public function province()
    {
        return $this->belongsTo(Lookups::class, 'province_cd', 'id');
    }
    public function city()
    {
        return $this->belongsTo(Lookups::class, 'city_cd', 'id');
    }
    public function district()
    {
        return $this->belongsTo(Lookups::class, 'district_cd', 'id');
    }

    public function setStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'investor_status')
                       ->where('item_key', $statusKey)
                       ->firstOrFail();

        $this->status_cd = $status->id;
        return $this;
    }

    public function getStatusKey(): ?string
    {
        return optional($this->statusLookup)->item_key;
    }

    // Convenience methods
    public function markAsPending() { return $this->setStatus(self::STATUS_PENDING); }
    public function markAsApproved() { return $this->setStatus(self::STATUS_APPROVED); }
    public function markAsRejected() { return $this->setStatus(self::STATUS_REJECTED); }

    // Status check methods
    public function isPending(): bool { return $this->getStatusKey() === self::STATUS_PENDING; }
    public function isApproved(): bool { return $this->getStatusKey() === self::STATUS_APPROVED; }
    public function isRejected(): bool { return $this->getStatusKey() === self::STATUS_REJECTED; }

}
