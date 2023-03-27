<?php

namespace App\Models\Offer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    use HasFactory;

    public function offer_metrics()
    {
        return $this->hasOne(OfferMetrics::class);
    }
    public function campaigns()
    {
        return $this->hasOne(Campaign::class);
    }
}
