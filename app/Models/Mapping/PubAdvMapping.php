<?php

namespace App\Models\Mapping;

use App\Buyer;
use App\Buyersetup;
use App\Models\LeadLog\LeadLog;
use App\Models\Offer\Offer;
use App\Models\Partner\Partner;
use App\Models\Postback\Postback;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PubAdvMapping extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [];

    protected $table = 'pub_advertisers';

    /**
     *  Get Single Buyer
     *
     * @param null $search
     * @return array
     */
    public static function GetSingleBuyer($search = null)
    {
        $query = DB::table(
            'buyer-setup', 'bs')
            ->leftJoin(
                'buyers as b',
                'bs.buyer_id',
                '=',
                'b.id'
            );

        $query->where('bs.status', '=', 1)
            ->where('b.status', '=', 1)
            ->where('bs.leadtype', $search['leadType'])
            ->where('bs.id', $search['setupid'])
            ->where('bs.buyer_id', $search['buyer_id']);

        if (!empty($search['mode'])) {
            $query->where('bs.mode', $search['mode']);
        } else {
            $query->where('bs.mode', '=', 1);
            $query->orderBy('bs.tier_price', 'DESC');

            return $query->get()->toArray();
        }
    }

    /**
     * Get Buyer from Pub ADV table
     *
     * @param null $search
     */
    public static function GetBuyer($search)
    {
//        dd($leadtype);
        $query = DB::table('pubbuyermappings', 'pb')
            ->select(
                'pb.*',
                'buyer-setup.*',
                'buyers.*',
                'lms_buyer_leadtype.*',
//                'buyer_filters.*'
            )
            ->leftJoin(
                'buyer-setup',
                'pb.buyersetup_id',
                '=',
                'buyer-setup.id')
            ->leftJoin(
                'buyers',
                'pb.buyer_id',
                '=',
                'buyers.id')
            ->leftJoin(
                'lms_buyer_leadtype',
                'pb.buyersetup_id',
                '=',
                'lms_buyer_leadtype.buyersetup_id');

        $query
            ->where('buyer-setup.status', 1)
            ->where('pb.status',1)
            ->where('buyers.status', 1)
            ->where('pb.leadtype', $search['leadtype'])
            ->where('pb.vid', $search['vid']);

        if (!empty($search['id'])) {
            $query->where('buyers.id', $search['id']);
        }
        if (!empty($search['tier_price']))
            $query->where('buyer-setup.tier_price', '>=', $search['tier_price']);
        if (!empty($search['tier_price_max']))
            $query->where('buyer-setup.tier_price','<', $search['tier_price_max']);
        if (!empty($search['mode'])) {
            $query->where('buyer-setup.mode', $search['mode']);
        } else
            $query->where('buyer-setup.mode',1);

        $query->orderBy('buyer-setup.tier_price', 'DESC')
            ->orderBy('pb.id', 'ASC');
//        dd($query->get()->toArray());

        return $query->get()->toArray();
    }


    public function partners()
    {
        return $this->belongsToMany(Partner::class);
    }
    public function lead_logs()
    {
        return $this->hasMany(LeadLog::class);
    }
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function postback()
    {
        return $this->hasMany(Postback::class);
    }

}
