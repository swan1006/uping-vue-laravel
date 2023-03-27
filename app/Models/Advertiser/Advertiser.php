<?php

namespace App\Models\Advertiser;

use App\Models\User;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function company()
    {
        return $this->hasOne(User\Company::class);
    }

//    public function offer()
//    {
//        return $this->hasOne(Offer::class);
//    }

}
