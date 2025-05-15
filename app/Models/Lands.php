<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lands extends Model
{
    use HasFactory;

    protected $table = 'lands';
    protected $guarded = []; // للسماح لكل الحقول (مع الانتباه للمخاطر الأمنية)


    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';


    public function statusLookup()
    {
        return $this->belongsTo(Lookups::class, 'legal_status_cd', 'id')
            ->where('master_key', 'legal_status_cd');
    }

    public function setStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'legal_status_cd')
            ->where('item_key', $statusKey)
            ->firstOrFail();

        $this->legal_status_cd = $status->id;
        return $this;
    }
    public function markAsPending() { return $this->setStatus(self::STATUS_PENDING); }
    public function markAsApproved() { return $this->setStatus(self::STATUS_APPROVED); }
    public function markAsRejected() { return $this->setStatus(self::STATUS_REJECTED); }

    // Status check methods
    public function isPending(): bool { return $this->getStatusKey() === self::STATUS_PENDING; }
    public function isApproved(): bool { return $this->getStatusKey() === self::STATUS_APPROVED; }
    public function isRejected(): bool { return $this->getStatusKey() === self::STATUS_REJECTED; }

    public function getStatusKey(): ?string
    {
        return optional($this->statusLookup)->item_key;
    }

    public function investor()
    {
        return $this->belongsTo(Investors::class, 'investor_id');
    }
    public function attachments()
    {
        return $this->hasMany(Attachments::class, 'land_id');
    }


}
