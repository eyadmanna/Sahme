<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lands extends Model
{
    use HasFactory;

    protected $table = 'lands';
    protected $guarded = []; // للسماح لكل الحقول (مع الانتباه للمخاطر الأمنية)


    const VALUATION_STATUS_PENDING = 'pending';
    const VALUATION_STATUS_APPROVED = 'approved';
    const VALUATION_STATUS_EDIT_REQUEST = 'edit_request';

    const LEGAL_STATUS_PENDING = 'pending';
    const LEGAL_STATUS_APPROVED = 'approved';
    const LEGAL_STATUS_REJECTED = 'rejected';

    public function statusLookup()
    {
        return $this->belongsTo(Lookups::class, 'legal_status_cd', 'id')
            ->where('master_key', 'legal_status_cd');
    }
    public function valuationstatusLookup()
    {
        return $this->belongsTo(Lookups::class, 'valuation_status_cd', 'id')
            ->where('master_key', 'valuation_status_cd');
    }

    public function setStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'legal_status_cd')
            ->where('item_key', $statusKey)
            ->firstOrFail();

        $this->legal_status_cd = $status->id;
        return $this;
    }
    public function setValuationStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'valuation_status_cd')
            ->where('item_key', $statusKey)
            ->firstOrFail();

        $this->valuation_status_cd = $status->id;
        return $this;
    }

    public function markAsLegalPending() { return $this->setStatus(self::LEGAL_STATUS_PENDING); }
    public function markAsLegalApproved() { return $this->setStatus(self::LEGAL_STATUS_APPROVED); }
    public function markAsLegalRejected() { return $this->setStatus(self::LEGAL_STATUS_REJECTED); }

    public function isLegalPending(): bool { return $this->getStatusKey() === self::LEGAL_STATUS_PENDING; }
    public function isLegalApproved(): bool { return $this->getStatusKey() === self::LEGAL_STATUS_APPROVED; }
    public function isLegalRejected(): bool { return $this->getStatusKey() === self::LEGAL_STATUS_REJECTED; }

    
    public function markAsValuationPending() { return $this->setValuationStatus(self::VALUATION_STATUS_PENDING); }
    public function markAsValuationApproved() { return $this->setValuationStatus(self::VALUATION_STATUS_APPROVED); }
    public function markAsValuationEditRequest() { return $this->setValuationStatus(self::VALUATION_STATUS_EDIT_REQUEST); }

    public function isValuationPending(): bool { return $this->getValuationStatusKey() === self::VALUATION_STATUS_PENDING; }
    public function isValuationApproved(): bool { return $this->getValuationStatusKey() === self::VALUATION_STATUS_APPROVED; }
    public function isValuationEditRequest(): bool { return $this->getValuationStatusKey() === self::VALUATION_STATUS_EDIT_REQUEST; }

    public function getStatusKey(): ?string
    {
        return optional($this->statusLookup)->item_key;
    }

    public function getValuationStatusKey(): ?string
    {
        return optional($this->valuationStatusLookup)->item_key;
    }

    public function investor()
    {
        return $this->belongsTo(Investors::class, 'investor_id');
    }
    public function attachments()
    {
        return $this->hasMany(Attachments::class, 'reference_id_fk');
    }


}
