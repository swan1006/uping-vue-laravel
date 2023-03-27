<?php

namespace App\Http\Controllers;

use App\Buyersetup;
use App\CheckStatus;

use App\Http\Requests\LeadPostRequestCA;
use App\Jobs\PostLeadToBuyersCA;
use App\LmsPartnerLeadType;
use App\Models\LmsPaydayCA;
use App\Models\LmsPaydayUK;
use App\Partner;
use App\Buyer;
use App\Offer;
use App\Pubbuyermapping;
use App\CheckStatusLogger;
use App\Lmscallcenter;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class CALeadController extends Controller
{
    var $leadtype = 'paydayca';

    var $partner_detail = '';
    var $partner_status = '';


    public function index()
    {
        $datas = LmsPaydayCA::orderBy('id', 'DESC');
        $subids = $datas->pluck('subid');
        $datas = $datas->get();

        $partners = Partner::all();
        $buyers = Buyer::all();
        $buyersetups = Buyersetup::all();
        $pubbuyers = Pubbuyermapping::all();
        $offers= Offer::all();


        return view('admin.leads.leads-ca',
            compact('datas', 'partners', 'buyers', 'buyersetups','pubbuyers', 'offers', 'subids'));


    }
    public function show($id)
    {
        $data = LmsPaydayCA::find($id);

        return view('admin.leads-view', compact('data'));
    }
    public function edit($id)
    {
        $data = LmsPaydayCA::find($id);

        return view('admin.leads-edit', compact('data'));
    }

    /**
     * This function accepts applications and posts/maps them to the DB.
     *
     * @param LeadPostRequestCA $request
     */
    public function post(LeadPostRequestCA $request)
    {
        if ($request->input(['vid']) == null) {
            return response('Affiliate ID is required', 300);
        }
//        Log::info('DEBUG::', (array)$request->input('vid'));
        if ($request->input(['oid']) == null) {
            $request['oid'] = '3';
        }

         // start the post process/timers
//        $startTime = explode(' ', microtime());
//        $startTime = $startTime[1] + $startTime[0];

        // Retrieve Partner Account Status if VID present.
        $this->partner_status = Partner::GetPartnerFullDetail(
            $request->input('vid'), $this->leadtype);

        if ($this->partner_status === 'Partner Not Active') {
            return $this->partner_status;
        }




        // Fetch the Partner details if present and return it.
        $this->partner_detail = Partner::get_callcenter_fulldetail(
            $request->input('vid'), $this->leadtype);

        if ($this->partner_detail === 'Partner Route Not Active') {
            return $this->partner_detail;
        }

        // Mapping + Add Lead to Database
        $this->store($request);
        $post = $request->input(NULL, TRUE);
        $post = (object)$post;

        //Check for duplicates and limits setup up against affiliates.
        $partner_limits = (new LmsPartnerLeadType)->partner_limits($request, $this->partner_detail, $this->leadtype);

        if (!$partner_limits instanceof Request) {
            echo $partner_limits;
            die();
        }


        // Add the Log to lms partner lead type table
        $data['vid'] = $request->input('vid');
        $data['post_data'] = http_build_query($_POST);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['leadid'] = LmsPaydayCA::latest()->first()->id;
        $partner_log = LmsPaydayCA::add_log_partner($data);
        $partnerlogid = $partner_log->id;

        /*
        * Email Validation - IPQualityScore - Fraud Scoring
        */
//        $email = $post['email'];
//        $this->ipqs($email);
//        (new \App\LmspaydayUS)->quality_check();


        // Get Generated Lead ID and log it to Telescope
        $post->leadid = DB::table('lmspayday_c_a_s')->latest()->first()->id;
        $post->istest = $request->input('istest');
        Log::info('Lead ID: ' . $post->leadid);
        Log::info('TestMode: ' . $post->istest);


        // Get transaction ID if present - Get sub affiliate IDs
        $transaction_id = $request->input('transaction_id');

        // By default, it will be DIRECT
        Log::info('Transaction ID: ' . isset($transaction_id));

        // Try to determine the sub affiliate ID
        if ($transaction_id !== null && $transaction_id !== false && trim($transaction_id) !== '') {

            // Update lead ID in offers log
            $offer = new Offer();
            $offer->AddLeadId($transaction_id, $post->leadid);

            // Get tracking details
            $tracking_details = $offer->GetPostback(['transaction_id' => $transaction_id]);
            Log::info('Tracking details ' . $tracking_details);

            // One of them could be click ID and the other the sub affiliate ID
            // Sub affiliate ID are mostly upto 4 digits in length
            if (strlen($tracking_details['aff_sub1']) <= 6) {
                $_POST['sub_aff_id'] = $tracking_details['aff_sub1'];
            } else if (strlen($tracking_details['aff_sub2']) <= 6) {
                $_POST['sub_aff_id'] = $tracking_details['aff_sub2'];
            } else {

                // Could not determine which one is sub affiliate ID
                $_POST['sub_aff_id'] = 'UNKNOWN';
            }
        }



        // Post application to buyer
        // Status Check Code
        $inputs = $request->input();
        $status_check = new CheckStatus();
        $status_check->leadid = $post->leadid;
        $status_check->status = "pending";
        $status_check->percentage = 0;
        $status_check->correlationId = Str::uuid();
        $status_check->save();
//        dd(123);

        // Passing all required parameters to Job to get processed.
        PostLeadToBuyersCA::dispatch($post, $inputs, $this->partner_detail, $partnerlogid, $data, $status_check);
        $resp = $this->curl_response_status($status_check);
        echo $resp;
        die();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \App\Models\LmsPaydayCA
     */
    public function store(Request $request)
    {

        $data = new \App\Models\LmsPaydayCA;
//        $data['istest'] = $this->toString($request->input('istest'));
        $data['istest'] = $this->toString($request->input('istest'));
        $data['vid'] = $this->toString($request->input('vid'));
        $data['subid'] = $this->toString($request->input('subid'));
//        $data['campaignId'] = $request->input('campaignId');
        $data['tier'] = $this->toString($request->input('tier'));

        $data['loanPurpose'] = $this->toString($request->input('loanPurpose'));
        $data['loanAmount'] = $this->toString($request->input('loanAmount'));
        $data['loanTerms'] = $this->toString($request->input('loanTerms'));

        $data['nameTitle'] = $this->toString($request->input('nameTitle'));
        $data['firstName'] = $this->toString($request->input('firstName'));
        $data['lastName'] = $this->toString($request->input('lastName'));

        $data['dateOfBirthDay'] = $this->toString($request->input('dateOfBirthDay'));
        $data['dateOfBirthMonth'] = $this->toString($request->input('dateOfBirthMonth'));
        $data['dateOfBirthYear'] = $this->toString($request->input('dateOfBirthYear'));

        $data['email'] = $this->toString($request->input('email'));
        $data['gender'] = $this->toString($request->input('gender'));
        $data['maritalStatus'] = $this->toString($request->input('maritalStatus'));
        $data['dependants'] = $this->toString($request->input('dependants'));

        $data['cellPhoneNumber'] = $this->toString($request->input('cellPhoneNumber'));
        $data['homePhoneNumber'] = $this->toString($request->input('homePhoneNumber'));
        $data['workPhoneNumber'] = $this->toString($request->input('workPhoneNumber'));

        $data['employerName'] = $this->toString($request->input('employerName'));
        $data['jobTitle'] = $this->toString($request->input('jobTitle'));
        $data['employmentMonth'] = $this->toString($request->input('employmentMonth'));
        $data['employerIndustry'] = $this->toString($request->input('employerIndustry'));

        $data['incomeSource'] = $this->toString($request->input('incomeSource'));
        $data['incomeCycle'] = $this->toString($request->input('incomeCycle'));
        $data['monthlyIncome'] = $this->toString($request->input('monthlyIncome'));
        $data['CombinedMonthlyHouseholdIncome'] = $this->toString($request->input('CombinedMonthlyHouseholdIncome'));

        $data['nextPayDateDay'] = $this->toString($request->input('nextPayDateDay'));
        $data['nextPayDateMonth'] = $this->toString($request->input('nextPayDateMonth'));
        $data['nextPayDateYear'] = $this->toString($request->input('nextPayDateYear'));

        $data['followingPayDateDay'] = $this->toString($request->input('followingPayDateDay'));
        $data['followingPayDateMonth'] = $this->toString($request->input('followingPayDateMonth'));
        $data['followingPayDateYear'] = $this->toString($request->input('followingPayDateYear'));

        $data['houseNumber'] = $this->toString($request->input('houseNumber'));
        $data['houseName'] = $this->toString($request->input('houseName'));
        $data['flatNumber'] = $this->toString($request->input('flatNumber'));
        $data['addressStreet1'] = $this->toString($request->input('addressStreet1'));
        $data['addressStreet2'] = $this->toString($request->input('addressStreet2'));
        $data['city'] = $this->toString($request->input('city'));
        $data['state'] = $this->toString($request->input('county'));
        $data['zip'] = $this->toString($request->input('zip'));

        $data['residentialStatus'] = $this->toString($request->input('residentialStatus'));
        $data['monthsAtAddress'] = $this->toString($request->input('monthsAtAddress'));

        $data['ssn'] = $this->toString($request->input('ssn'));
        $data['licenseNumber'] = $this->toString($request->input('licenseNumber'));
        $data['licenseState'] = $this->toString($request->input('licenseState'));
        $data['inMilitary'] = $this->toString($request->input('inMilitary'));

        $data['monthlyMortgageRent'] = $this->toString($request->input('monthlyMortgageRent'));
        $data['monthlyRepayments'] = $this->toString($request->input('monthlyRepayments'));
        $data['monthlyUtilities'] = $this->toString($request->input('monthlyUtilities'));
        $data['monthlyTransport'] = $this->toString($request->input('monthlyTransport'));
        $data['monthlyFood'] = $this->toString($request->input('monthlyFood'));
        $data['otherExpense'] = $this->toString($request->input('otherExpense'));

        $data['bankDirectDeposit'] = $this->toString($request->input('bankDirectDeposit'));
        $data['bankName'] = $this->toString($request->input('bankName'));
        $data['bankCardType'] = $this->toString($request->input('bankCardType'));
        $data['bankAccountNumber'] = $this->toString($request->input('bankAccountNumber'));
        $data['bankRoutingNumber'] = $this->toString($request->input('bankRoutingNumber'));
        $data['bankPhone'] = $this->toString($request->input('bankPhone'));
        $data['bankMonthYear'] = $this->toString($request->input('bankMonthYear'));
        $data['bankAccountType'] = $this->toString($request->input('bankAccountType'));

        $data['NationalIdentityNumber'] = $this->toString($request->input('NationalIdentityNumber'));

        $data['consentFinancial'] = $this->toString($request->input('consentFinancial'));
        $data['consentCreditSearch'] = $this->toString($request->input('consentCreditSearch'));
        $data['consentThirdPartyEmails'] = $this->toString($request->input('consentThirdPartyEmails'));
        $data['consentThirdPartySMS'] = $this->toString($request->input('consentThirdPartySMS'));
        $data['consentThirdPartyPhone'] = $this->toString($request->input('consentThirdPartyPhone'));



        $res = $data->save();
        // dd($res);
        return $data;

    }

    /*
     * This function will fetch the list of PaydayUK leads data coming from the model
     */

    private function toString($val)
    {
        if (gettype($val) == 'object' || gettype($val) == 'array') {
            $res = json_encode($val);
            return $res;
        } else
            return $val;
    }


    /*
     * Randomize the buyers every 3 posts
     *
     * @param $row
     * @param string $type
     */
    public function GetBuyerObject($row, $type = 'lead_post')
    {
        if ($row->post_url_live == 'random') {
            $buyerIndex = $row->parameter3;
            $buyer_used_count = $row->parameter2;
            $buyer_total_count = $row->parameter1;


            $buyers = json_decode(trim($row->notes));
            if ($type == 'lead_post') {
                $buyer_used_count++;
                if ($buyer_used_count > $buyer_total_count) {
                    $buyerIndex++;
                    if ($buyerIndex >= count($buyers)) {
                        $buyerIndex = 0;
                    }
                    $buyer_used_count = 1;
                }
                $buyer = (new Buyersetup)->UpdateParameters(
                    $row->buyersetupid,
                    $buyer_total_count,
                    $buyer_used_count,
                    $buyerIndex
                );
            }

            $buyer = $buyers[$buyerIndex];
            $search['leadtype'] = $this->leadtype;
            $search['buyerid'] = $buyer->buyerid;
            $search['setupid'] = $buyer->setupid;

            $v = Pubbuyermapping::GetSingleBuyer($search);
            $row = (object)$v[0];
        }

        return $row;
    }

    /*
     * Return XML Response OLD
     *
     * @param $client_response
     * @return string
     */
    function curl_response_post($client_response)
    {
        header("Content-type: text/xml; charset=utf-8");
        $res = '<?xml version="1.0"?>';
        $res .= '<PostResponse>';
        $res .= ($client_response['status'] == '1') ? '<Response>Accepted</Response>' : '<Response>Rejected</Response>';

//        $res .= ($client_response['status'] == '1') ? '<Leadid>' . $client_response['leadid'] . '</Leadid>' : '<Leadid>' . $client_response['leadid'] . '</Leadid>';
        $res .= ($client_response['status'] == '1') ? '<Price>' . $client_response['price'] . '</Price>' : '';
        $res .= ($client_response['status'] == '1') ? '<RedirectURL>' . 'http://127.0.0.1:8000/api/application/ca/redirecturl/' . $this->redirecturl_encrypt($client_response['leadid']) . '</RedirectURL>' : '';
        $res .= ($client_response['status'] == '1' && !empty($client_response['Threshold'])) ? '<Threshold>' . $client_response['Threshold'] . '</Threshold>' : '';
        $res .= ($client_response['status'] == '1' && !empty($client_response['ThresholdAmount'])) ? '<ThresholdAmount>' . $client_response['ThresholdAmount'] . '</ThresholdAmount>' : '';
//         $res .= ($client_response['status'] == '2') ? '<Descriptions>' . $client_response['Descriptions'] . '</Descriptions>' : '';
//         $res .= ($client_response['status'] == '2') ? '<PercentageComplete>' . $client_response['PercentageComplete'] . '</PercentageComplete>' : '';
//        $res .= isset($client_response['correlation_id']) ? '<CorrelationId>' . $client_response['correlation_id'] . '</CorrelationId>' : '';
//        $res .= ($client_response['status'] == '1') ? '<LenderFound>' . $client_response['LenderFound'] . '</LenderFound>' : '';
        $res .= isset($client_response['check_status_id']) ? '<CheckStatusID>' . $client_response['check_status_id'] . '</CheckStatusID>' : '';
        $res .= isset($client_response['check_status']) ? '<CheckStatus>' . $client_response['check_status'] . '</CheckStatus>' : '';

        //Errors setting up
//        $res .= isset($client_response['check_status']) ? '<CheckStatus>' . $client_response['check_status'] . '</CheckStatus>' : '';

        $res .= isset($client_response['postback_method']) ? '<PostbackMethod>' . $client_response['postback_method'] . '</PostbackMethod>' : '';
        $res .= isset($client_response['iframe_url']) ? '<IframeURL>' . $client_response['iframe_url'] . '</IframeURL>' : '';
        $res .= '</PostResponse>';
        return $res;
    }

    /*
     * This function returns Check Status Responses
     *
     * @param $check_status
     * @return string
     */
    function curl_response_status($check_status)
    {
        $url = route('api-check-status', $check_status->correlationId);
        header("Content-type: text/xml; charset=utf-8");
        $res = '<?xml version="1.0"?>';
        $res .= '<PostResponse>';
        $res .= '<PercentageComplete>' . $check_status->percentage . '</PercentageComplete>';
        $res .= '<CheckStatusID>' . $check_status->correlationId . '</CheckStatusID>';
        $res .= '<CheckStatus>' . $check_status->status . '</CheckStatus>';
        $res .= '<CheckStatusURL>' . $url . '</CheckStatusURL>';
        $res .= '</PostResponse>';

        return $res;

    }

    /*
     * This function handles the redirection url ( encrypt )
     */

    public function redirecturl_encrypt($id)
    {
        return $secure = rand(10, 99) . $id . rand(10, 99);
    }


    /*
     * This function handles the redirection url ( decrypt )
     * @param $id
     * @return false|string
     */
    public function redirecturl_decrypt($id)
    {
        return $unsecure = substr(substr($id, 2), 0, -2);
    }

    /*
     * This function handles the redirect for the OLD check status
     *
     * @param $id
     */
    public function redirecturl($id)
    {
        $CheckStatusLogger = new CheckStatusLogger;
        $api_received_at = Carbon::now()->microsecond;



        $data['id'] = $this->redirecturl_decrypt($id);
        $data['created_at'] = date('Y-m-d H:i:s', strtotime('-15 minutes'));
        $redirecturl = (new LmsPaydayCA)->UpdateRedirectUrl($data);


        if ($redirecturl) {
            // Add new check status log for this redirect
            $CheckStatusLogger->lead_id = $data['id'];
            $CheckStatusLogger->country_code = $data['uk'];
            $CheckStatusLogger->request['api_received_at'] = $api_received_at;
            $CheckStatusLogger->response['api_issued_at'] = Carbon::now()->microsecond;
            $CheckStatusLogger->response['progress_percentage'] = 'REDIRECTED';
            $CheckStatusLogger->add();


            header("location: " . $redirecturl);
            exit;
        } else {
            echo 'Invalid/Expired Redirect URL';
            exit;
        }
    }

    /*
     * This function will check for tiers
     *
     * @param $str
     * @return bool
     */
    public function tier_check($str)
    {
        if (!array_key_exists($str, config('array.paydayca_tiers'))) {

            echo 'tier_check', 'The %s field value is out of the given list.';

            return false;
        } else {
            return true;
        }
    }


    /*
     * This function calls the IPQS curl post
     *
     * @param $email
     */
    public function ipqs($email)
    {
        $ipqs = \config('ipqs');
        foreach ($ipqs as $k => $v)
            $key = $ipqs[0];
        $timeout = $ipqs[1];
        $fast = $ipqs[2];
        $abuse_strictness = $ipqs[3];

        $url = 'https://ipqualityscore.com/api/json/email/' . $key . '/' . $email;

        $parameters = array(
            'timeout' => $timeout,
            'fast' => $fast,
            'abuse_strictness' => $abuse_strictness
        );

        $formatted_parameters = http_build_query($parameters);

        curl_ipqs(
            $url,
            $key,
            $email,
            $formatted_parameters
        );

//        return $result;

    }


    /*
     * This function checks the last check status ->  OLD check status
     *
     */
    public function last_check_status(Request $request)
    {
        dd($request);

        $CheckStatusLogger = new CheckStatusLogger;
        $check_status_id = $request->input('id');

        Log::info('DEBUG: Check Status ID is numeric: ' . (is_numeric($check_status_id)));


        if (is_numeric($check_status_id)) {
            $CheckStatusLogger->updateStatus($check_status_id,
                [
                    'response_affiliate_received_at' => $request->input('response_affiliate_received_at'),
                    'response_affiliate_issued_at' => $request->input('response_affiliate_issued_at'),
                    'response_client_received_at' => $request->input('response_client_received_at')
                ]);
        }
    }

    /*
     * This function handles the new check status,
     * checks against the check status id.
     *
     * @param Request $request
     * @param $id
     */
    public function CheckStatusNew(Request $request, $correlationId)
    {
        $status_check = CheckStatus::where('correlationId', '=', $correlationId)->first();
        if ($status_check->status == 'pending') {
            echo $this->curl_response_status($status_check);
        } else {
            header("Content-type: text/xml; charset=utf-8");
            echo $status_check->resp;
        }

        Log::info('DEBUG:: Check Status ID is numeric');
        $leadid = $request->input('leadid');


        die();

    }

    /*
     * This function checks the check status  -> OLD
     *
     */
    public function CheckStatus(Request $request)
    {
        dd($request);
        $CheckStatusLogger = new CheckStatusLogger;
        $check_status_id = $request->input('id');

        Log::info('DEBUG: Check Status ID is numeric: ' . print_r(is_numeric($check_status_id), true));

        if (is_numeric($check_status_id)) {
            $CheckStatusLogger->updateStatus($check_status_id,
                [
                    'response_affiliate_received_at' => $request->input('response_affiliate_received_at'),
                    'response_affiliate_issued_at' => $request->input('response_affiliate_issued_at'),
                    'response_client_received_at' => $request->input('response_client_received_at')
                ]);
        }

        $leadid = $request->input('leadid');
        $CheckStatusLogger->lead_id = $leadid;
        $CheckStatusLogger->country_code = 'uk';
        $CheckStatusLogger->request = [
            'client_issued_at' => $request->input('request_client_issued_at'),
            'affiliate_received_at' => $request->input('request_affiliate_received_at'),
            'affiliate_issued_at' => $request->input('request_affiliate_issued_at'),
            'api_received_at' => Carbon::now()->microsecond
        ];

        Log::info('DEBUG: CHECK STATUS LEAD ID ' . $leadid);

        // Fetch the status of the lead ID from the DB
        $res = LmsPaydayCA::CheckStatus($leadid);
        $post_response = $res[0]->post_response;

        // Get log ID from the DB using lead ID
        $partnerlogid = LmsPaydayCA::FindPartnerLogId($leadid);
        $partnerlogid = $partnerlogid[0]->id;
        $vid = $partnerlogid[0]->vid;

        $buyer = new Buyer;
        $buyer->$res[0]->buyer_id;


        // Call the buyer API
        $filename = app_path("Buyerapis/" . $this->leadtype . '/' . strtolower($buyer['company']) . ".php");

        if (file_exists($filename)) {

            require_once($filename);

            $classname = strtolower($buyer['company']);
            $obj = new $classname();

            $lender_response = $obj->CheckStatus($post_response);
//            dd($lender_response);


            // Parse the XML response
//            dd($res[0])
            if ($res[0]->buyer_id == 1) {
                $last_post_response = $post_response . '<br/>' . trim(preg_replace('/\s+/', ' ', $lender_response['post_res']));
            } elseif ($res[0]->buyer_id = 2) {
                $last_post_response = $post_response;
            }

            $datalogo = array(
                'leadid' => $leadid,
                'buyersetup_id' => $res[0]->buyersetup_id,
                'post_url' => $res[0]->post_url,
                'post_data' => $res[0]->post_data,
                'post_response' => $last_post_response,
                'post_price' => $lender_response['post_price'],
                'post_status' => $lender_response['post_status'],
            );

            if ($lender_response['percentage'] == 100) {
                $res_log = (new LmsPaydayCA)->UpdateLog($datalogo);
            }

            if ($lender_response['accept'] == 'ACCEPTED') {
                // Lead has been accepted
                // Calculate price
                $lender_response['post_price'] = (float)$lender_response['post_price'];
                $this->partner_detail = Partner::get_callcenter_fulldetail($vid, $this->leadtype);

                $price = $lender_response['post_price'] - (float)($lender_response['post_price'] *
                        ((float)$this->partner_detail->margin / 100));


                // Update lead details in the database
                $data = array(
                    'buyerid' => $res[0]->buyerid,
                    'buyerLeadPrice' => $lender_response['post_price'],
                    'vidLeadPrice' => $price,
                    'buyerTierID' => $res[0]->buyersetup_id,
                    'redirectUrl' => $lender_response['redirect_url'],
                    'leadStatus' => '1',
                    'id' => $leadid
                );
                $res = (new LmsPaydayCA)->add($data);


                // Calculate affiliate margin
                $this->offer_detail = Offer::get($request->input('oid'));
                $thresholdAmount = $this->offer_detail['payoutAmount'];
                $offerid = $this->offer_detail['id'];

                // Separate threshold amount for VID 87 and OID.
                $postback_method = 'http';
                $iframe_url = '';
                if ($vid == 87 && $offerid == 7) {
                    $thresholdAmount = 10;
                } else if ($vid == 69 && $offerid == 7) {
                    $thresholdAmount = 20;
                } else if ($vid == 122 && $offerid == 7) {
                    $thresholdAmount = 11;
                } else if ($vid == 108 && $offerid == 2) {
                    $postback_method = 'iframe';
                    $tracking_details = Offer::GetPostback([
                        'transaction_id' => $request->input('transaction_id')]);
                }


                $response = array(
                    'status' => $data['leadStatus'],
                    'price' => $data['vidLeadPrice'],
                    'leadid' => $data['id'],
                    'LenderFound' => $lender_response['status']
                );

                if ($thresholdAmount > 0 && ($offerid == 5 || $offerid == 7)) {
                    if ($offerid == 5) {
                        $accumulatorAmount = (float)$this->partner_detail->accuCPAuk65;
                    } elseif ($offerid == 7) {
                        $accumulatorAmount = (float)$this->partner_detail->accuCPLuk9;
                    }

                    $accumulatorAmount = ($accumulatorAmount) + ($response['price']);
                    $response['ThresholdAmount'] = $thresholdAmount;

                    if ($accumulatorAmount >= $thresholdAmount) {
                        $accumulatorAmount = $accumulatorAmount - $thresholdAmount;
                        $response['Threshold'] = 'true';
                    } else {
                        $response['Threshold'] = 'false';
                    }
                    if ($offerid == 5) {
                        $lead_data = array(
                            'id' => $this->partner_detail->id,
                            'accuCPAuk65' => $accumulatorAmount
                        );
                    } elseif ($offerid == 7) {
                        $lead_data = array(
                            'id' => $this->partner_detail->id,
                            'accuCPLuk9' => $accumulatorAmount
                        );
                    }


                    // Update affiliate earnings
                    Lmscallcenter::AddLeadType($lead_data);


                    // Rev-share
                } elseif ($offerid == 2) {
                    $response['Threshold'] = 'true';
                    $response['ThresholdAmount'] = $price;
                }
                if ($this->partner_detail->currencyType != 1) {
                    $rate = LmsPaydayCA::GetDailyRate();
                    $response['price'] = $data['vidLeadPrice'] * $rate['usd'];
                }


                // Prepare response
                $CheckStatusLogger->response['api_issued_at'] = Carbon::now()->microsecond;
                $CheckStatusLogger->response['progress_percentage'] = $lender_response['status'];

                $response['check_status_id'] = $CheckStatusLogger->add();
                $response['postback_method'] = $postback_method;
                $response['iframe_url'] = $iframe_url;

                $post_response = $this->curl_response_post($response);


                $data_pub = array(
                    'id' => $partnerlogid,
                    'leadid' => $leadid,
                    'post_response' => $post_response,
                    'post_status' => $response['status']
                );

                // Update the partners log with this response
                $res_pub = LmsPaydayCA::add_log_partner($data_pub);

                Log::info('DEBUG: CHECK STATUS LEAD ID ' . $leadid . ': Final response: ' . print_r($post_response, true));

                print_r($post_response);
                die;

            } else {
                // Lead is not accepted
                // Prepare a response
                $response = array(
                    'status' => 2,
                    'PercentageComplete' => $lender_response['percentage'],
                    'Descriptions' => $lender_response['percentage'],
                    'LenderFound' => $lender_response['status']
                );


                $CheckStatusLogger->response['api_issued_at'] = Carbon::now()->microsecond;
                $CheckStatusLogger->response['progress_percentage'] = $lender_response['percentage'];
                $response['check_status_id'] = $CheckStatusLogger->add();


                $post_response = $this->curl_response_post($response);

                Log::info('DEBUG: CHECK STATUS LEAD ID ' . $leadid . ': Final response: ' . print_r($post_response, true));


                print_r($post_response);
                die;
            }
        }
    }

    /**
     * This function is an ajax function.
     * Gets the Data for rendering based on the query.
     *
     * @param Request $request
     */
    public function GetLmsUsData(Request $request)
    {

        $vid = $request->input("vid");
        $buyerid = $request->input("buyerid");
        $status = $request->input("status");
        $subid = $request->input("subid");
        $tierid = $request->input("tierid");

        if($request->input("date")!=null){
            $date = Carbon::createFromFormat('d/m/Y', $request->input("date"));
        }else{
            $date = null;
        }
        if($request->input("enddate")!=null){
            $enddate = Carbon::createFromFormat('d/m/Y', $request->input("enddate"));
        }else{
            $enddate = null;
        }

        $wherelist = array();
        if ($vid != null) {
            $wherelist[] = ['vid', '=', $vid];
        }
        if ($buyerid != null) {
            $wherelist[] = ['buyerid', '=', $buyerid];
        }
        if ($tierid != null) {
            $wherelist[] = ['buyerTierID', '=', $tierid];
        }
        if ($subid != null) {
            $wherelist[] = ['subid', '=', $subid];
        }
        if ($status != null) {
            $wherelist[] = ['leadStatus', '=', $status];
        }
        if ($date != null) {
            $wherelist[] = ['created_at', '>=', $date];
        }
        if ($enddate != null) {
            $wherelist[] = ['created_at', '<=', $enddate];
        }
        $datas = LmsPaydayCA::where($wherelist)->get();

        echo json_encode(['data' => $datas]);
    }

}
