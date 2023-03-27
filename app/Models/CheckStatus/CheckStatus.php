<?php

namespace App\Models\CheckStatus;

//use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckStatus extends Model
{
    use HasFactory;
//        Uuids;

    protected $table = 'status_check';

    public $timestamps = true;

    protected $hidden = [
        'id'
    ];

    protected $fillable = [
        'leadid',
        'status',
        'percentage',
        'correlationId',
        'resp',
    ];



    public function getRouteKeyName()
    {
        return 'correlationId';
    }
}

