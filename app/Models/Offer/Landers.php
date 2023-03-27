<?php

namespace App\Models\Offer;

use App\Offer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landers extends Model
{
    use HasFactory;

    public function offer()
    {
        return $this->belongsToMany(Offer::class);
    }
}
