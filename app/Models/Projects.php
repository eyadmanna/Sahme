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

    const ENGINEERING_CONSULTANT_EVALUATION_STATUS_PENDING = 'pending';
    const ENGINEERING_CONSULTANT_EVALUATION_STATUS_NEEDEDIT = 'need_edit';
    const ENGINEERING_CONSULTANT_EVALUATION_STATUS_NONEEDEDIT = 'no_need_edit';

    const PROJECT_APPROVAL_STATUS_PENDING = 'pending';
    const PROJECT_APPROVAL_STATUS_APPROVED = 'approved';
    const PROJECT_APPROVAL_STATUS_REJECTED = 'rejected';


    const AWARDED_ENGINEERING_CREATOR_STATUS_PENDING = 'pending';
    const AWARDED_ENGINEERING_CREATOR_STATUS_APPROVED = 'approved';
    const AWARDED_ENGINEERING_CREATOR_STATUS_REJECTED = 'rejected';




    public function statusLookup()
    {
        return $this->belongsTo(Lookups::class, 'project_status_cd', 'id')
            ->where('master_key', 'project_status_cd');
    }
    public function evaluationstatusLookup()
    {
        return $this->belongsTo(Lookups::class, 'engineering_consultant_evaluation_status_cd', 'id')
            ->where('master_key', 'engineering_consultant_evaluation_status_cd');
    }
    public function projectstatusLookup()
    {
        return $this->belongsTo(Lookups::class, 'approval_status_cd', 'id')
            ->where('master_key', 'project_approval_status_cd');
    }
    public function awardedstatusLookup()
    {
        return $this->belongsTo(Lookups::class, 'awarded_engineering_creator_approval_cd', 'id')
            ->where('master_key', 'awarded_engineering_creator_approval_cd');
    }
    public function setStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'project_status_cd')
            ->where('item_key', $statusKey)
            ->firstOrFail();

        $this->project_status_cd = $status->id;
        return $this;
    }
    public function setEvaluationStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'engineering_consultant_evaluation_status_cd')
            ->where('item_key', $statusKey)
            ->firstOrFail();

        $this->engineering_consultant_evaluation_status_cd = $status->id;
        return $this;
    }
    public function setProjectStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'project_approval_status_cd')
            ->where('item_key', $statusKey)
            ->firstOrFail();

        $this->approval_status_cd = $status->id;
        return $this;
    }
    public function setAwardedStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'awarded_engineering_creator_approval_cd')
            ->where('item_key', $statusKey)
            ->firstOrFail();

        $this->awarded_engineering_creator_approval_cd = $status->id;
        return $this;
    }

    public function lands()
    {
        return $this->belongsTo(Lands::class, 'land_id');
    }

}
