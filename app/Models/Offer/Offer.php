<?php

namespace App\Models\Offer;

use App\Models\Lead\UKLead;
use App\Models\Offer\OfferCap;
use App\Models\Advertiser\Advertiser;
use App\Models\Offer\Campaign;
//use App\Models\ClickTracker;
use App\Models\Offer\Creatives;
use App\Models\Offer\Landers;
//use App\Models\LMSApplication\Payout;
//use App\Models\UKLead;
//use App\Models\OfferMetrics;
use App\Models\Offer\Payout;
use App\Models\Partner\Partner;
use App\Models\Postback;
use App\Models\PostbackTracker;
use App\Models\Offer\TargetGroup;
use App\Models\Offer\Tracking;
//use App\Models\TrafficSource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
//use Kyranb\Footprints\TrackableInterface;
//use Kyranb\Footprints\TrackRegistrationAttribution;

class Offer extends Model
{
    use HasFactory;
//        TrackRegistrationAttribution;

    protected $guarded = [];

    /** Model Relations */
    public function partners()
    {
        return $this->belongsToMany(Partner::class);
    }
    public function creatives()
    {
        return $this->hasMany(Creatives::class);
    }
    public function landers()
    {
        return $this->hasMany(Landers::class);
    }
    public function target_group()
    {
        return $this->hasOne(TargetGroup::class);
    }
    public function campaign()
    {
        return $this->hasOne(Campaign::class);
    }
    public function tracking()
    {
        return $this->hasOne(Tracking::class);
    }
    public function payout()
    {
        return $this->hasOne(Payout::class);
    }
    public function offer_cap()
    {
        return $this->hasOne(OfferCap::class);
    }
    public function advertiser()
    {
        return $this->hasOne(Advertiser::class);
    }


    /**
     * This function gets the offer associated with the OID.
     * @param null $id
     * @return mixed|string
     */
    public static function get($id)
    {
        $query = Offer::with(
            [
                'tracking',
                'campaign',
                'advertiser',
                'target_group',
                'landers',
                'payout',
                'offer_cap',
                'target_group',
                'creatives'

            ]);
        // where condition if id is present
        if ($id !== null) {
            $query->where('id', $id)->first();
        }
        if ($id === null) {
            return 'Invalid Offer ID';
        }

        return $query->get()->first();
    }

    /**
     * Get conversion rate , USD, GBP etc.
     * @param $partner_detail
     * @param $data
     * @return mixed
     */
    public static function get_conversion_rate($partner_detail, $data)
    {

        if ($partner_detail->currencyType != 1) {
            $rate = UKLead::getdailyrate();
            $data->convertedAmount = $rate->usd;
        }

        return $data;
    }

    /**
     * This function adds the revenue to the LmsOffersLog
     * @param $data
     * @return Builder
     */
    public static function AddRevenue($data)
    {
        if (!empty($data['transaction_id'])) {
            $query = DB::table('lms_offers_log')
                ->where('transactionId', $data['transaction_id'])
                ->get();

            $row = $query->toArray();
            $row = json_decode(json_encode($row), true);
//            dd($row);

//            dd($data);
            if (empty($data['amount'])) {

                // CPA/CPL
                $query = DB::table('offers')
                    ->where('id', $row[0]['oid'])
                    ->get();
//                dd($query);
                $rows = $query->toArray();
                $rows = json_decode(json_encode($rows), true);
//                dd($rows);


                // Default
                $thresholdAmount = $rows[0]['payoutAmount'];

                if ((int)$row[0]['oid'] == 8) {
                    switch ((int)$row[0]['oid'] == 8) {
                        case 69:
                        case 59:
                            $thresholdAmount = 50;
                            break;

                        case 67:
                            $thresholdAmount = 22;
                            break;

                        case 105:
                            $thresholdAmount = 25;
                            break;

                        case 122:
                            $thresholdAmount = 40;
                            break;

                        case 117:
                            break;

                    }
                } elseif ((int)$row[0]['vid'] == 97 && $row[0]['oid'] == 7) {
                    $thresholdAmount = 10;
                } elseif ((int)$row[0]['vid'] == 69 && $row[0]['oid'] == 7) {
                    $thresholdAmount = 20;
                } elseif ((int)$row[0]['vid'] == 122 && $row[0]['oid'] == 7) {
                    $thresholdAmount = 11;
                }

//                dd($data);
                if (!empty($data['amount'])) {
                    $data['amount'] = $thresholdAmount * $data['convertedAmount'];
                }
//                dd($data);
            } else {

                // rev-share
                // Partner margin applied
                $data['amount'] = $data['amount'];
            }

            $data = array(
                'conversions' => '1',
                'totalRevenue' => $data['amount'],
                'affiliatePostbackUrl' => $data['affiliatePostbackUrl']
            );
//            dd($data);
//            dd($row);
//            dd($row[0]['totalCost']);


            $res = DB::table('lms_offers_log')
                ->where('id', $row[0]['id']);

            $res->update($data);

            return $res;
        }
    }

    /**
     * This function adds the revenue to the LmsOffersLog
     * @param $data
     * @return Builder
     */
    public static function AddOfferRevenue($data)
    {
        if (!empty($data['transaction_id'])) {
            $query = DB::table('lms_offers_log')
                ->where('transactionId', $data['transaction_id'])
                ->get();

            $row = $query->toArray();
            $row = json_decode(json_encode($row), true);
//            dd($row);

            // CPA
            if (empty($data['amount'])) {

                $query = DB::table('offers')
                    ->where('id', $row[0]['oid'])
                    ->get()->toArray();

                $rows = $query;
                $rows = json_decode(json_encode($rows), true);

                $data['amount'] = $rows[0]['payoutAmount'];
                $totalRevenue = $data['amount'];


                $query = DB::table('lms_partner_leadtype')
                    ->where('vid', $row[0]['vid'])
                    ->where('type', 'offer')
                    ->pluck('margin');

                $data['amount'] = $data['amount'] - ($data['amount'] * ($query[0] / 100));
                $data['amount'] = json_encode($data['amount']);

            }

            $data = array(
                'conversions' => '1',
                'totalCost' => $data['amount'],
                'totalRevenue' => $totalRevenue,
                'affiliatePostbackUrl' => $data['affiliatePostbackUrl']
            );
//            dd($data);
//            dd($row);
//            dd($row[0]['totalCost']);


            $res = DB::table('lms_offers_log')
                ->where('id', $row[0]['id']);

            $res->update($data);
//            dd($res->get());

            return $res;
        }
    }

    /**
     * This function adds the $data to the Offers Log.
     * @param $data
     */
    public static function OfferLog($data)
    {
        $data->aff_click_id = (string)Str::uuid();
        $data->transaction_id = (string)Str::uuid();
        $data->save();

        $query = DB::table('click_trackers');

        $res = $query->latest()->first();

        return $res;
    }


    /**
     * Get the trafficSource -> encode
     * @param $value
     */
    public function setTrafficSourceAttribute($value)
    {
        $this->attributes['trafficSource'] = json_encode($value);
    }

    /**
     * Get the trafficSource -> decode
     * @param $value
     * @return mixed
     */
    public function getTrafficSourceAttribute($value)
    {
        return $this->attributes['trafficSource'] = json_decode($value);
    }
//    /**
//     * Get the geos -> encode
//     * @param $value
//     */
//    public function setGeosAttribute($value)
//    {
//        $this->attributes['geos'] = json_encode($value);
//    }

//    /**
//     * Get the geos -> decode
//     * @param $value
//     * @return mixed
//     */
//    public function getGeosAttribute($value)
//    {
//        return $this->attributes['geos'] = json_decode($value);
//    }

    /**
     * This function gets the vid value
     * @return array
     */
    public function getvidvalue()
    {
        $query = DB::table('lms_callcenter')
            ->orderBy('id', 'ASC')
            ->get();

        $return = array();

        if ($query->count() > 0) {
            foreach ($query->toArray() as $row) {
                json_decode(json_encode($row), true);
                $return[$row->id] = $row->company;
            }
        }
        return $return;
    }


    /**
     * This function updates the lead id in the offers log.
     * @param $transaction_id
     * @param $lead_id
     * @return int
     */
    public static function AddLeadId($transaction_id, $lead_id)
    {
        $query = DB::table('lms_offers_log_us');

        $query
            ->where('transactionId', $transaction_id)
            ->updateOrInsert(['leadid', $lead_id]);

//        $response = DB::update($data);
        return $data;
    }

    /**
     * This function gets the associated Offer Affiliate Mapping Setup
     * @param $id
     * @return Model|Builder|object|null
     */
    public function GetOAM($id)
    {
        $query = DB::table('lmsoffermaps')
            ->where('oid', $id);

        return $query->first();
    }

    /**
     * This function gets the form submits associated with my-Loans.
     * @param $search
     * @return array
     */
    public function GetFormSubmits($search)
    {
        $db_myloans = DB::connection('myloans');
//        $db_myloans = $this->load(database_path('myloans'));

        $db_myloans->select('oid', 'count(id)');

        if (!empty($search['daterange'])) {
            list($sdate, $edate) = explode(" - ", $search['daterange']);
            $db_myloans->where('submitted_on >=', $sdate . ' 00:00:00');
            $db_myloans->where('submitted_on <=', $edate . " 23:55:00");
        } else {
            $db_myloans->where('submitted_on >=', date('Y-m-d', strtotime('-1 days')) . ' 00:00:00');
            $db_myloans->where('submitted_on <=', date('Y-m-d') . " 23:55:00");
        }
        if (!empty($search['oid'])) {
            $db_myloans->where('oid', $search['oid']);
        }

        if (!empty($search['vid'])) {
            $db_myloans->where('vid', $search['vid']);
        }

        $db_myloans->groupBy('oid');
        $form_submits = $db_myloans->get('lead_log');
        $form_submits = $form_submits->toArray();
        $form_submits_assoc = [];
        foreach ($form_submits as $value) {
            $form_submits_assoc[$value['oid']] = $value['count(id)'];
        }
        return $form_submits_assoc;
    }

    /**
     * This function gets the Invalid Form Submits associated with my-Loans.
     * @param $search
     * @return array
     */
    public function GetInvalidForms($search)
    {
        // Get number of form submits
        $db_myloans = $this->load->database('myloans', TRUE);
        $db_myloans->select('oid, count(id)');
        $db_myloans->where('response_code', 'validation_errors');
        if (!empty($search['daterange'])) {
            list($sdate, $edate) = explode(" - ", $search['daterange']);
            $db_myloans->where('submitted_on >=', $sdate . ' 00:00:00');
            $db_myloans->where('submitted_on <=', $edate . " 23:55:00");
        } else {
            $db_myloans->where('submitted_on >=', date('Y-m-d', strtotime('-1 days')) . ' 00:00:00');
            $db_myloans->where('submitted_on <=', date('Y-m-d') . " 23:55:00");
        }


        if (!empty($search['oid'])) {
            $db_myloans->where('oid', $search['oid']);
        }

        if (!empty($search['vid'])) {
            $db_myloans->where('vid', $search['vid']);
        }


        $db_myloans->groupBy('oid');
        $form_submits = $db_myloans->get('lead_log');
        $form_submits = $form_submits->toArray();
        $form_submits_assoc = [];
        foreach ($form_submits as $value) {
            $form_submits_assoc[$value['oid']] = $value['count(id)'];
        }
        return $form_submits_assoc;
    }

    /**
     * This function gets the Valid Form Submits associated with my-Loans.
     * @param $search
     * @return array
     */
    public function GetValidForms($search)
    {
        // Get number of form submits
        $db_myloans = $this->load->database('myloans', TRUE);
        $db_myloans->select('oid, count(id)');
        $db_myloans->where('response_code <>', 'validation_errors');
        if (!empty($search['daterange'])) {
            list($sdate, $edate) = explode(" - ", $search['daterange']);
            $db_myloans->where('submitted_on', '>=', $sdate . ' 00:00:00');
            $db_myloans->where('submitted_on', '<=', $edate . " 23:55:00");
        } else {
            $db_myloans->where('submitted_on', '>=', date('Y-m-d', strtotime('-1 days')) . ' 00:00:00');
            $db_myloans->where('submitted_on', '<=', date('Y-m-d') . " 23:55:00");
        }

        if (!empty($search['oid'])) {
            $db_myloans->where('oid', $search['oid']);
        }

        if (!empty($search['vid'])) {
            $db_myloans->where('vid', $search['vid']);
        }

        $db_myloans->groupBy('oid');
        $form_submits = $db_myloans->get('lead_log');
        $form_submits = $form_submits->toArray();
        $form_submits_assoc = [];
        foreach ($form_submits as $value) {
            $form_submits_assoc[$value['oid']] = $value['count(id)'];
        }
        return $form_submits_assoc;
    }



}
