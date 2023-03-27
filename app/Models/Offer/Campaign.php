<?php

namespace App\Models\Offer;


use App\Models\Creatives;
use App\Models\LMSApplication\Payout;
use App\Models\OfferCap;
use App\Models\Partner\Partner;
use App\Models\Offer\Offer;
//use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $table = 'campaigns';

    public function partners()
    {
        return $this->hasMany(Partner::class);
    }
    public function offers()
    {
        return $this->hasOne(Offer::class);
    }
    public function creatives()
    {
        return $this->hasOne(Creatives::class);
    }
//    public function landers()
//    {
//        return $this->hasOne(Lander::class);
//    }
//    public function payouts()
//    {
//        return $this->hasOne(Payout::class);
//    }
//    public function offer_caps()
//    {
//        return $this->hasOne(OfferCap::class);
//    }
//    public function payouts()
//    {
//        return $this->hasOne(Payout::class);
//    }

    //    public function flows()
//    {
//        return $this->hasOne(Flow::class);
//    }
//    public function offer_metrics()
//    {
//        return $this->hasOne(OfferMetrics::class);
//    }
//    public function traffic_sources()
//    {
//        return $this->hasOne(TrafficSource::class);
//    }
//    public function flows()
//    {
//        return $this->hasOne(Flow::class);
//    }
}
