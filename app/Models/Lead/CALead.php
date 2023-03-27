<?php

namespace App\Models;

use App\Buyer;
use App\Buyersetup;
use App\CheckStatusLogger;
use App\Http\Controllers\LeadTestController;
use App\Http\Controllers\LeadTestControllerUS;
use App\Lmsleadlog;
use App\LmsPartnerLeadType;
use App\Partner;
use App\Pubbuyermapping;
use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CALead extends Model
{
    use HasFactory, Uuids;

    public $timestamps = true;
    public $incrementing = false;
    protected $guarded = [];
    protected $table = 'lmspaydayuks';
    protected $keyType = 'string';
    protected $primaryKey = 'id';


    public
    function source()
    {
        return $this->hasOne(Source::class, 'lead_id');
    }

    public
    function loan()
    {
        return $this->hasOne(Loan::class, 'lead_id');
    }

    public
    function applicant()
    {
        return $this->hasOne(Applicant::class, 'lead_id');
    }

    public
    function employer()
    {
        return $this->hasOne(Employer::class, 'lead_id');
    }

    public
    function residence()
    {
        return $this->hasOne(Residence::class, 'lead_id');
    }

    public
    function bank()
    {
        return $this->hasOne(Bank::class, 'lead_id');
    }

    public
    function consent()
    {
        return $this->hasOne(Consent::class, 'lead_id');
    }
    public
    function expense()
    {
        return $this->hasOne(Expenses::class, 'lead_id');
    }

    public
    function additional()
    {
        return $this->hasOne(Additional::class, 'lead_id');
    }


    /**
     * Date Format
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        // Set the default format of date
        return Carbon::parse($value)->format("d M Y h:i A");
    }

    /*
     * End DB Model Attributes
     */

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function pubbuyers()
    {
        return $this->hasMany(Pubbuyermapping::class);
    }
    public function partners()
    {
        return $this->belongsTo(Partner::class);
    }
    public function buyers()
    {
        return $this->hasMany(Buyer::class);
    }
    public function buyersetups()
    {
        return $this->hasMany(Buyersetup::class);
    }
    public function checkstatuses()
    {
        return $this->hasMany(CheckStatusLogger::class);
    }
    public function lms_partner_leadtypes()
    {
        return $this->hasMany(LmsPartnerLeadType::class);
    }
    public function lms_lead_logs()
    {
        return $this->hasMany(Lmsleadlog::class);
    }

    /**
     * Check the status of the lead id
     * @param $leadid
     * @return mixed
     */
    public static function CheckStatus( $leadid )
    {
        $query = DB::table('lmsleadlogs')
            ->where('leadid', $leadid)
            ->get()
            ->first();

        return $query;
    }


    /**
     * This function will take the post data passed from the controller
     * if id is present, then it will do an update, else an insert.
     * @param $data
     */
    public static function add_log_partner( $data )
    {
        $query = DB::table('lms_lead_paydayuk_partner');


        if (isset($data['leadid'])) {
            $query->where('leadid', $data['leadid'])
                ->updateOrInsert($data);
        }

        $result = $query->get()->first();

        return $result;
    }

    /**
     * This function will take the post data passed from the controller
     * if id is present, then it will do an update, else an insert.
     * @param $data
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function update_log_partner( $data )
    {
        $query = DB::table('lms_lead_paydayuk_partner');

        if (isset($data['id'])) {
            $query->where('id', $data['id'])
                ->update($data);

        } else {
            $query->insert($data);
        }

        $result = $query->get()->first();
//        dd($result);

        return $result;
    }


    /**
     * Get the VID lead logs
     * @param $id
     * @return mixed
     */
    public function getvendorlog($id)
    {
        $query = DB::table('lmsleadlogs');

        if (!empty($id)) {
            $query->where('leadid', $id);
        }
        $rows = $query->get()->first();

        return $rows;
    }

    /**
     * This function will add a lead payday uk log
     * @param $data
     * @return bool
     */
    public static function AddLog($data)
    {
        if (!empty($data)) {
            $res = DB::table('lmsleadlogs')->insert($data);
        }
        return $res;
    }

    /**
     * Get the current conversion rates for UK & USA.
     * @return mixed
     */
    public static function GetDailyRate()
    {
        $query = DB::table('lms_daily_rates')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->first();

        return $query;
    }

    /**
     * This function updates the redirect URL
     * @param $search
     * @return false|mixed
     */
    public function UpdateRedirectUrl($search)
    {
//        dd($search);
        $query = DB::table('lmspaydayuks');

        if (isset($search['id']) && !empty($search['id'])) {
            $query->where('id', $search['id'])
                ->where('created_at', '>', $search['created_at']);

            $row = $query->get()->first();
            Log::info('Redirect ROW::', (array) $row);


            if (!empty($row->redirectUrl)) {
                $data['id'] = $search['id'];
                $data['isRedirected'] = '1';

                $query->where('id', $data['id']);
                $res = $query->update(['id' => $data['id'], 'isRedirected' => $data['isRedirected']]);

                $data_log['isRedirected'] = '1';
                $query = DB::table('lmsleadlogs');

                $query->where('leadid', $search['id'])
                    ->where('buyersetup_id', $row->buyerTierID);

                $res = $query->update(['isredirected' => $data_log['isRedirected']]);
                return $row->redirectUrl;
            }
        }
        return false;
    }

    /**
     * This function updates the lead logs
     * @param $data
     * @return \Illuminate\Database\Query\Builder
     */
    public function UpdateLog($data)
    {
        $res = DB::table('lmsleadlogs');

        if (!empty($data)) {
            if (!empty($data['leadid'])) {
                $query = DB::table($this)
                    ->where('leadid', $data['leadid'])
                    ->where('buyersetup_id', $data['buyersetup_id'])
                    ->update($data);
                }
        }
        return $res;
    }

    /**
     * Find the partner Log ID
     * @param $leadid
     */
    public static function FindPartnerLogId($leadid)
    {
         $res = DB::table('lms_lead_paydayuk_partner')
            ->where('leadid', $leadid)
            ->get();

         return $res;
    }


    /**
     * This function updates or inserts the $data ( lead ).
     * @param $data
     * @return bool|int
     */
    public function add( $data )
    {
        $query = DB::table('lmspaydayuks');

        if (isset($data['id'])) {
            $query->where('id', $data['id']);

            $res = $query->update($data);
        } else {
            $res = $query->insert($data);
        }

        return $res;
    }

    /**
     * This function gets the VID log associated with the lead id.
     * @param $id
     * @return mixed
     */
    public static function get_vendor_log($id)
    {
        $query = DB::table('lms_lead_paydayuk_partner');

        if (!empty($id)) {
            $query->where('leadid', $id);
        }
        $rows = $query->get()->toArray();

        return $rows;

    }

    /**
     * Get the Log from lead log table based on the id provided.
     * @param $id
     * @return array
     */
    public static function getlog($id)
    {
        $query = DB::table('lmsleadlogs');

        if (!empty($id)) {
            $query->where('leadid', $id)
                ->orderBy('created_at', 'DESC');
        }
        $rows = $query->get()->toArray();

        return $rows;
    }

    /**
     * This function checks the fraud_score for the lead and
     * updates the lead column in the lms payday uk table.
     * @return int
     */
    public function quality_check()
    {
        $query = DB::table('lmspaydayuks');

        if (isset($result['fraud_score'])) {
            $query->where('quality_score', $result['fraud_score']);


            $res = $query->update($result);
        }
        return $res;
    }

    /**
     * This function gets the buyers associated with the VID.
     * @param $post
     */
    public static function getBuyers($post)
    {
        $post = LmsPaydayUK::preBuyerPost($post);


        if ($post->istest == true) {
            $testBuyer = (new LeadTestController)->getTestBuyer();
            $post->buyer_list = $testBuyer;
        } else {

            $search = $post->search;
            $buyer_list = Pubbuyermapping::GetBuyer($search, $post);
            $post->buyer_list = $buyer_list;

        }

        return $post;
    }

    /**
     * This function sets relevant params on the incoming post for the getBuyer function
     * @param $post
     * @return mixed
     */
    public static function preBuyerPost($post)
    {
        $search = (object)[];

        if (isset($post->minCommissionAmount) && $post->minCommissionAmount != '0.00') {
            $search->min_price = $post->minCommissionAmount;
        }
        if (isset($post->minCommissionAmount) && $post->minCommissionAmount != '0.00') {
            $search->max_price = $post->maxCommissionAmount;
        }
        if (isset($post->tier)) {
            $search->tier = $post->tier;
        }

//        if (isset($post->timeout)) {
//                $search->timeout = $post->timeout;
//        }

        if (isset($post->vid)) {
            $search->vid = $post->vid;
        }

        if (isset($post->istest) && $post->istest === true) {
            $search->leadtype = 'testmodeuk';
        } else {
            $search->leadtype = 'paydayuk';
        }

        $post->search = $search;

        return $post;

    }

    /**
     * @param $buyerTierID
     * @return mixed
     */
    public static function getTierID($buyerTierID)
    {
        $filters = BuyerFilter::where('buyersetup_id', '=', $buyerTierID)
            ->where('filter_type', 'DateOfBirthDay')
            ->get()
            ->toArray();

        return $filters;
    }

     /**** Export functionality ***/
    public static function getLeads()
    {
        $u_id = Auth::id();
        $partner = DB::table('partners')->where('user_id', '=', $u_id)->get()->toArray();
        $vid = $partner[0]->id;

        $records = DB::table('lmspaydayuks')
            ->select(
                'id',
                'istest',
                'vid',
                'subid',
                'vidLeadPrice AS leadPrice',
                'leadStatus',
                'isRedirected',
                'ipaddress',
                'userAgent',
                'creationUrl',
                'referringUrl',
                'created_at AS timestamp',
            )
            ->where('vid', '=', $vid)
            ->get()->toArray();

        return $records;
    }


    public static function getAllLeads()
    {
        $records = DB::table('lmspaydayuks')
//            ->select(
//                'id',
//                'istest',
//                'vid',
//                'subid',
//                'vidLeadPrice AS leadPrice',
//                'leadStatus',
//                'isRedirected',
//                'ipaddress',
//                'userAgent',
//                'creationUrl',
//                'referringUrl',
//                'created_at AS timestamp',
//            )
            ->get()->toArray();

        return $records;
    }



}
