<?php

namespace App\Models\Buyer;

use App\Models\Invoice\Invoice;
use App\Models\Mapping\Mapping;
use App\Models\User\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $table="buyers";

    public function company()
    {
        return $this->hasOne(Company::class);
    }
    public function buyer_setup()
    {
        return $this->hasMany(BuyerSetup::class);
    }
    public function buyer_filter()
    {
        return $this->hasMany(BuyerFilter::class);
    }
        public function mappings()
    {
        return $this->hasMany(Mapping::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}
