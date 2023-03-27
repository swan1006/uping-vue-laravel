<?php

namespace App\Models\LMSApplication;


use App\Models\Lead\USLead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function us_lead()
    {
        return $this->hasOne(USLead::class, 'lead_id');
    }
    public function uk_lead()
    {
        return $this->hasOne(UKLead::class, 'lead_id');
    }

}
