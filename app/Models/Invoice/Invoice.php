<?php

namespace App\Models\Invoice;

use App\Models\Buyer\Buyer;
use App\Models\Buyer\BuyerSetup;
use App\Models\InvoiceProduct;
use App\Models\Partner\Partner;
use App\Models\User\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function partner()
    {
        return $this->hasOne(Partner::class);
    }
    public function company()
    {
        return $this->hasOne(Company::class);
    }
    public function buyer()
    {
        return $this->hasOne(Buyer::class);
    }
    public function buyer_setups()
    {
        return $this->hasMany(BuyerSetup::class);
    }
    public function invoice_products()
    {
        return $this->hasMany(InvoiceProduct::class);

    }


}
