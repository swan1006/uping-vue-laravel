<?php

namespace App\Models\User;

use App\Models\Buyer\Buyer;
use App\Models\Invoice\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class);
    }
//    public function buyer()
//    {
//        return $this->hasOne(Buyer::class);
//    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);

    }
}
