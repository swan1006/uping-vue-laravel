<?php

namespace App\Models\Offer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lander extends Model
{
    use HasFactory;

//    public function flows()
//    {
//        return $this->hasOne(Flow::class);
//    }
    public function traffic_sources()
    {
        return $this->hasOne(TrafficSource::class);
    }
    public function offer_metrics()
    {
        return $this->hasOne(OfferMetrics::class);
    }
    public function campaigns()
    {
        return $this->hasOne(Campaign::class);
    }
}
