<?php

namespace App\Models\LeadLog;

use App\Models\Lead\UKLead;
use App\Models\Mapping\Mapping;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadLog extends Model
{
    use HasFactory;

    protected $guarded = [];


//    public function lms_partner_leadtype()
//    {
//        return $this->hasMany(LmsPartnerLeadType::class);
//    }

    public function uk_leads()
    {
        return $this->hasMany(UKLead::class);
    }

    public function mappings()
    {
        return $this->hasMany(Mapping::class);
    }

}
