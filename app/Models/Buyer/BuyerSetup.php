<?php

namespace App\Models\Buyer;

use App\Models\Mapping\Mapping;
use App\Models\Partner\Partner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerSetup extends Model
{
    use HasFactory;

    protected $table="buyer_setups";



    public function buyer()
    {
        return $this->hasOne(Buyer::class);
    }
    public function mappings()
    {
        return $this->hasMany(Mapping::class);
    }
    public function buyer_filters()
    {
        return $this->hasMany(BuyerFilter::class);
    }
}
