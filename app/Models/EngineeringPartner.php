<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function statusLookup()
    {
        return $this->belongsTo(Lookups::class, 'status_cd', 'id')
                   ->where('master_key', 'engineering_partner_status');
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
