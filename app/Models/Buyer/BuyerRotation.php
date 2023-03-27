<?php

namespace App\Models\Buyer;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BuyerRotation extends Model
{
    use HasFactory;

    public function buyersetup()
    {
        return $this->belongsTo(BuyerSetup::class);
    }

    /**
     * Update Parameters on the buyer setup
     *
     * @param $id
     * @param $buyer_used_count
     * @param $buyer_total_count
     * @return false|Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function UpdateParameters($id, $buyer_used_count, $buyer_total_count, $buyerIndex)
    {
        $query = DB::table('buyer_rotations');

        try {
            $data= [];
            $data['buyer_used_count'] = $buyer_used_count;
            $data['buyer_total_count'] = $buyer_total_count;
            $data['buyer_index'] = $buyerIndex;
            $query->where('buyer_setup_id', '=', $id);

            $res = $query->update($data);

        } catch (\Exception $e) {
            Log::debug($e);
            return false;
        }
        return $query->first();
    }
}
