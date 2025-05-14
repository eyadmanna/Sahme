<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;

class EngineeringPartner extends Authenticatable
{
    use Notifiable;

    protected $table = 'engineering_partners';

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

    public function getFullAddressAttribute()
    {
        $locale = App::getLocale();

        $province = $this->province?->{'name_' . $locale} ?? '';
        $city = $this->city?->{'name_' . $locale} ?? '';
        $district = $this->district?->{'name_' . $locale} ?? '';
        $address = $this->address ?? '';

        return trim("{$province} - {$city} - {$district} - {$address} ", ' -');
    }

    public function statusLookup()
    {
        return $this->belongsTo(Lookups::class, 'status_cd', 'id')
                   ->where('master_key', 'engineering_partner_status');
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
        $status = Lookups::where('master_key', 'engineering_partner_status')
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
