<?php

namespace App\Models\Postback;

use App\Models\Offer\Offer;
use App\Models\Partner\Partner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postback extends Model
{
    use HasFactory;

    protected $table = 'postbacks';

    public function offers()
    {
        return $this->hasOne(Offer::class);
    }
    public function partner()
    {
        return $this->hasOne(Partner::class);
    }
}
