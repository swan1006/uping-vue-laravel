<?php

namespace App\Models\Trackers;

use App\Models\Buyer\BuyerSetup;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PingtreeTracker extends Model
{
    use HasFactory;

    public function buyersetup()
    {
        return $this->belongsTo(BuyerSetup::class);
    }


    /**
     * @param $buyer_tier_id
     * @return Model|Builder|int|object
     */
    public function GetEPL($buyer_tier_id)
    {


        $lead_count = UKLead::whereDate('created_at', '=', Carbon::today())
            ->where('model_type', '=', 5)
            ->where('buyerTierID', '=', $buyer_tier_id)
            ->count();
//        dd($lead_count);

        $total_sales = UKLead::whereDate('created_at', '=', Carbon::today())
            ->where('buyerTierID', '=', $buyer_tier_id)
            ->where('model_type', '=', 5)
            ->pluck('buyerLeadPrice')
            ->sum();
//        dd($total_sales);

        try {
            $epl_ratio = $total_sales / $lead_count;
            $epl_ratio = round($epl_ratio, 2);
        } catch (Exception $e) {
            Log::debug($e);
            $epl_ratio = 0;
        }

//        if (empty($epl_ratio)) {
//            return $epl_ratio = 0;
//        }

        $epl = $this->update_epl($epl_ratio, $buyer_tier_id);

        return $epl;
    }

    /**
     * @param $epl
     * @param $buyer_tier_id
     * @return Builder|Model|object
     */
    public static function update_epl($epl, $buyer_tier_id)
    {

        $buyer = DB::table('pingtree_trackers')->where('buyersetup_id', '=', $buyer_tier_id)->first();

        try {
            $tracker_update = PingtreeTracker::find($buyer->id);
            $tracker_update->buyersetup_id = $buyer_tier_id;
            $tracker_update->epl = $epl;
            $tracker_update->save();

            return $tracker_update;

        } catch (Exception $e) {
            Log::debug($e);
        }
    }
}
