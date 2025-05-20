<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = 'projects';

    use HasFactory;

    const PROJECT_STATUS_NEW = 'new';
    const PROJECT_STATUS_APPROVED = 'approved';
    const PROJECT_STATUS_REJECTED = 'rejected';
    const PROJECT_STATUS_ACCEPTING_OFFERS = 'accepting_offers';
    const PROJECT_STATUS_WAITING_FOR_AWARDING = 'waiting_for_awarding';
    const PROJECT_STATUS_AWARDED = 'awarded';
    const PROJECT_STATUS_AWARDING_APPROVED = 'awarding_approved';

    public function statusLookup()
    {
        return $this->belongsTo(Lookups::class, 'project_status_cd', 'id')
            ->where('master_key', 'project_status_cd');
    }
    public function setStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'project_status_cd')
            ->where('item_key', $statusKey)
            ->firstOrFail();

        $this->project_status_cd = $status->id;
        return $this;
    }
}
