<?php

namespace App\Models\Partner;

use App\Models\CALead;
use App\Models\Lead\UKLead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PartnerLeadType extends Model
{
    use HasFactory;

    protected $table = 'lms_partner_leadtype';

    protected $guarded = [];

    protected $casts = [];


    public function partners()
    {
        return $this->belongsTo(Partner::class);
    }

    public function uk_lead()
    {
        return $this->belongsTo(UKLead::class);
    }

    public function us_lead()
    {
        return $this->belongsTo(USLead::class);
    }

    public function ca_lead()
    {
        return $this->belongsTo(CALead::class);
    }

    /**
     * This function will handle all the partner lead type settings
     *
     * @param Request $request
     * @param $partner_detail
     * @param $leadtype
     * @return Request | string
     */
    public function partner_limits(Request $request, $partner_detail, $leadtype)
    {
        // Check for duplicates
        $partner_duplicate_errors = $this->isduplicate($request, $partner_detail, $leadtype);
        // Check for lead limits
        $partner_limit_errors = $this->lead_limits($request->input('vid'), $partner_detail, $leadtype);
        // Check for credit limits
        $partner_credit_errors = $this->credit_limits($request->input('vid'), $partner_detail, $leadtype);

        if (isset($partner_duplicate_errors) && $partner_duplicate_errors !== false) {
            return 'Duplicate lead';
        }
        if (!isset($partner_limit_errors) && $partner_limit_errors !== false) {
            return 'Limit reached';
        }
        if (!isset($partner_credit_errors) && $partner_credit_errors !== false) {
            return 'Credit Limit reached';
        }

        return $request;
    }

    /**
     * This function checks for duplicates based on the settings setup with affiliate.
     * True on Duplicate
     * False on No Duplicate
     * @param $request
     * @param $partner_detail
     * @param $leadtype
     * @return bool
     */
    public function isduplicate($request, $partner_detail, $leadtype)
    {
        $day = $partner_detail->daytotal;

        $search = (object)[];

        if (!empty($day)) {
            $search->tier = $request->input('tier');
            $search->email = $request->input('email');
            $search->created_at = date('Y-m-d', strtotime('-1' . $day . ' days'));

            if ($leadtype === 'paydayuk') {
                $search->phone = $request->input('mobilePhoneNumber');
            } elseif ($leadtype === 'paydayus') {
                $search->phone = $request->input('cellPhoneNumber');
            } else {
                $search->phone = $request->input('cellPhoneNumber');
            }


            if ($partner_detail->duplicateEmail === "1") {
                if (!empty($search->email)) {
                    $result = $this->duplicate_email($search->email, $leadtype);

                    if ((!$result->isEmpty())) {
                        return 'Duplicate Email';
                    }
                }
            }

            if ($partner_detail->duplicatePhone === "1") {
                if (!empty($search->phone)) {
                    $result = $this->duplicate_phone($search->phone, $leadtype);

                    if ((!$result->isEmpty())) {
                        return 'Duplicate Phone';
                    }
                }
            }

            if (!empty($search->tier)) {
                $result = $this->duplicate_tier($search->tier, $leadtype);
                if ($result->isNotEmpty() !== null) {
                    return true;
                } else {
                    return false;
                }
            }
            if (!empty($search->created_at)) {
                $result = $this->duplicate_days($search->created_at, $leadtype);
                if ($result->isNotEmpty() !== null) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    /**
     * @param $email
     * @param $leadtype
     * @return Collection
     */
    public function duplicate_email($email, $leadtype): Collection
    {
        switch ($leadtype) {
            case 'paydayuk':
                return DB::table('lmspaydayuks')->where('email', $email)->get();
            case 'paydayus':
                return DB::table('lmspayday_u_s')->where('email', $email)->get();
            case 'paydayca':
                return DB::table('lmspayday_c_a_s')->where('email', $email)->get();
        }
    }

    /**
     * @param $phone
     * @param $leadtype
     * @return Collection
     */
    public function duplicate_phone($phone, $leadtype): Collection
    {
        switch ($leadtype) {
            case 'paydayuk':
                return DB::table('lmspaydayuks')->where('mobilePhoneNumber', $phone)->get();
            case 'paydayus':
                return DB::table('lmspayday_u_s')->where('cellPhoneNumber', $phone)->get();
            case 'paydayca':
                return DB::table('lmspayday_c_a_s')->where('cellPhoneNumber', $phone)->get();
        }
    }

    /**
     * @param $search
     * @param $leadtype
     * @return Collection
     */
    public function duplicate_tier($search, $leadtype): Collection
    {
        switch ($leadtype) {
            case 'paydayuk':
                return DB::table('lmspaydayuks')->where('tier', $search)->get();
            case 'paydayus':
                return DB::table('lmspayday_u_s')->where('tier', $search)->get();
            case 'paydayca':
                return DB::table('lmspayday_c_a_s')->where('tier', $search)->get();
        }
    }

    /**
     * @param $date
     * @param $leadtype
     * @return Collection|void
     */
    public function duplicate_days($date, $leadtype)
    {
        switch ($leadtype) {
            case 'paydayuk':
                return DB::table('lmspaydayuks')->where('created_at', $date)->get();
            case 'paydayus':
                return DB::table('lmspayday_u_s')->where('created_at', $date)->get();
            case 'paydayca':
                return DB::table('lmspayday_c_a_s')->where('created_at', $date)->get();
        }
    }


    /**
     * This function handles the limits on the PartnerLeadType table
     * Get the VID from the request, and check it against the PartnerLeadType table for Lead Limits
     * @param $vid
     * @param $partner_detail
     * @param $leadtype
     * @return object|bool
     */
    public function lead_limits($vid, $partner_detail, $leadtype)
    {

        $daylimit = $partner_detail->daylimit;
        $weeklimit = $partner_detail->weeklimit;
        $monthlimit = $partner_detail->monthlimit;

        $search = (object)[];
        $search->vid = $vid;
        $search->created_at_daylimit = date('Y-m-d');
        $search->created_at_weeklimit = date('Y-m-d', strtotime('-7days'));
        $search->created_at_monthlimit = date('Y-m-d', strtotime('-30days'));

        $result = $this->lead_limit_totals($search, $leadtype);

        $error = (object)[];
        if (isset($result->dayTotal) && $result->dayTotal >= $daylimit) {
            $error->limit_type = 'Day Total Exceeded';
        } elseif (isset($result->WeekTotal) && $result->WeekTotal >= $weeklimit) {
            $error->limit_type = 'Week Total Exceeded';
        } elseif (isset($result->MonthTotal) && $result->MonthTotal >= $monthlimit) {
            $error->limit_type = 'Month Total Exceeded';
        } else {
            $error = false;
        }
        return $error;
    }

    /**
     * This function queries the Payday UK Table and counts all leads posted
     * within a certain timeframe.
     * @param $search
     * @param $leadtype
     * @return object
     */
    public static function lead_limit_totals($search, $leadtype)
    {
        $query = (object)[];

        if ($leadtype === 'paydayuk') {
            $monthtotal = DB::table('lmspaydayuks');
        } elseif ($leadtype === 'paydayus') {
            $monthtotal = DB::table('lmspayday_u_s');
        } else {
            $monthtotal = DB::table('lmspayday_c_a_s');
        }
        $monthtotal
            ->select(DB::raw('count(created_at) as Total'))
            ->where('vid', $search->vid)
            ->where('created_at', '>', $search->created_at_monthlimit);
        $query->monthTotal = $monthtotal->get();


        if ($leadtype === 'paydayuk') {
            $weektotal = DB::table('lmspaydayuks');
        } elseif ($leadtype === 'paydayus') {
            $weektotal = DB::table('lmspayday_u_s');
        } else {
            $weektotal = DB::table('lmspayday_c_a_s');
        }
        $weektotal
            ->select(DB::raw('count(created_at) as Total'))
            ->where('vid', $search->vid)
            ->where('created_at', '>', $search->created_at_weeklimit);
        $query->weekTotal = $weektotal->get();


        if ($leadtype === 'paydayuk') {
            $daytotal = DB::table('lmspaydayuks');
        } elseif ($leadtype === 'paydayus') {
            $daytotal = DB::table('lmspayday_u_s');
        } else {
            $daytotal = DB::table('lmspayday_c_a_s');
        }
        $daytotal
            ->select(DB::raw('count(created_at) as Total'))
            ->where('vid', $search->vid)
            ->where('created_at', '>', $search->created_at_daylimit);
        $query->dayTotal = $daytotal->get();

        $result = (object)[];
        $result->MonthTotal = $query->monthTotal[0]->Total;
        $result->WeekTotal = $query->weekTotal[0]->Total;
        $result->dayTotal = $query->dayTotal[0]->Total;

        return $result;
        }


    /**
     * This function handles the limits on the PartnerLeadType table
     * Get the VID from the request, and check it against the PartnerLeadType table for Credit Limits
     * @param $vid
     * @param $partner_detail
     * @param $leadtype
     * @return false|object
     */
    public function credit_limits($vid, $partner_detail, $leadtype)
    {
        $day_credit = $partner_detail->daycredit;
        $week_credit = $partner_detail->weekcredit;
        $month_credit = $partner_detail->monthcredit;

        $search = (object)[];
        $search->vid = $vid;
        $search->created_at_creditdaytotal = date('Y-m-d');
        $search->created_at_creditweektotal = date('Y-m-d', strtotime('-7days'));
        $search->created_at_creditmonthtotal = date('Y-m-d', strtotime('-30days'));

        $result = $this->credit_limit_totals($search, $leadtype);

        $error = (object)[];
        if (isset($result->dayTotal) && $result->dayTotal >= $day_credit) {
            $error->credit_limit_type = 'Day Credit Limit Exceeded';
        } elseif (isset($result->WeekTotal) && $result->WeekTotal >= $week_credit) {
            $error->credit_limit_type = 'Week Credit Limit Exceeded';
        } elseif (isset($result->MonthTotal) && $result->MonthTotal >= $month_credit) {
            $error->credit_limit_type = 'Month Credit Limit Exceeded';
        } else {
            $error = false;
        }
        return $error;
    }

    /**
     * This function queries the Payday UK Table and counts
     * the vidLeadPrice columns in a certain date range.
     * @param $search
     * @param $leadtype
     * @return object
     */
    public static function credit_limit_totals($search, $leadtype): object
    {

        $query = (object)[];

        if ($leadtype === 'paydayuk') {
            $monthtotal = DB::table('lmspaydayuks');
        } elseif ($leadtype === 'paydayus') {
            $monthtotal = DB::table('lmspayday_u_s');
        } else {
            $monthtotal = DB::table('lmspayday_c_a_s');
        }
        $monthtotal
            ->select(DB::raw('SUM(vidLeadPrice) as Total'))
            ->where('vid', $search->vid)
            ->where('created_at', '>', $search->created_at_creditmonthtotal);

        $query->monthTotal = $monthtotal->get();


        if ($leadtype === 'paydayuk') {
            $weektotal = DB::table('lmspaydayuks');
        } elseif ($leadtype === 'paydayus') {
            $weektotal = DB::table('lmspayday_u_s');
        } else {
            $weektotal = DB::table('lmspayday_c_a_s');
        }
        $weektotal
            ->select(DB::raw('SUM(vidLeadPrice) as Total'))
            ->where('vid', $search->vid)
            ->where('created_at', '>', $search->created_at_creditweektotal);

        $query->weekTotal = $weektotal->get();


        if ($leadtype === 'paydayuk') {
            $daytotal = DB::table('lmspaydayuks');
        } elseif ($leadtype === 'paydayus') {
            $daytotal = DB::table('lmspayday_u_s');
        } else {
            $daytotal = DB::table('lmspayday_c_a_s');
        }
        $daytotal
            ->select(DB::raw('SUM(vidLeadPrice) as Total'))
            ->where('vid', $search->vid)
            ->where('created_at', '>', $search->created_at_creditdaytotal);

        $query->dayTotal = $daytotal->get();


        $result = (object)[];
        $result->MonthTotal = $query->monthTotal[0]->Total;
        $result->WeekTotal = $query->weekTotal[0]->Total;
        $result->dayTotal = $query->dayTotal[0]->Total;

        return $result;
    }
}
