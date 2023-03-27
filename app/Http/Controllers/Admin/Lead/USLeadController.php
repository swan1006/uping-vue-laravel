<?php

namespace App\Http\Controllers\Admin\Lead;

use App\Http\Requests\LeadPostRequestUS;
use App\Jobs\PostLeadToBuyersUS;
use App\Models\Buyer\BuyerSetup;

use App\Helpers\CurlHelper;
use App\Http\Controllers\Controller;
use App\Jobs\PostLeadToBuyers;
use App\Models\CheckStatus\CheckStatus;
use App\Models\LMSApplication\Applicant;
use App\Models\LMSApplication\Bank;
use App\Models\LMSApplication\Consent;
use App\Models\LMSApplication\Employer;
use App\Models\LMSApplication\Expenses;
use App\Models\Lead\USLead;
use App\Models\LMSApplication\Loan;
use App\Models\Mapping\Mapping;
use App\Models\Partner\Partner;
use App\Models\LMSApplication\Residence;
use App\Models\LMSApplication\Source;

use Carbon\Carbon;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;


class USLeadController extends Controller
{

    var int $leadtype = 2;
    var $partner_detail = [];
    var $partner_status = '';

    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $vendor_id = $request->input("vendor_id");
        $sub_id = $request->input("sub_id");
        $tier = $request->input("tier");
        $vidLeadPrice = $request->input("vidLeadPrice");
        $buyerLeadPrice = $request->input("buyerLeadPrice");
        $lead_quality = $request->input("lead_quality");
        $redirection = $request->input("redirection");
        $status = $request->input("status");

        $query = $request->input("searchQuery");



        $wherelist = array();
        if ($vendor_id != null) {
            $wherelist[] = ['vid', '=', $vendor_id];
        }
        if ($sub_id != null) {
            $wherelist[] = ['subid', '=', $sub_id];
        }
        if ($tier != null) {
            $wherelist[] = ['tier', '=', $tier];
        }
        if ($vidLeadPrice != null) {
            $wherelist[] = ['vidLeadPrice', '=', $vidLeadPrice];
        }
        if ($buyerLeadPrice != null) {
            $wherelist[] = ['buyerLeadPrice', '=', $buyerLeadPrice];
        }
        if ($lead_quality != null) {
            $wherelist[] = ['quality_score', '=', $lead_quality];
        }
        if ($redirection != null) {
            $wherelist[] = ['isRedirected', '=', $redirection];
        }
        if ($status != null) {
            $wherelist[] = ['leadStatus', '=', $status];
        }

        if ($query != null) {
            $wherelist[] = ['', 'LIKE', $query];
        }

        $leads = USLead::with([
            'source',
            'loan',
            'applicant',
            'residence',
            'expense',
            'bank',
            'consent'
        ])->where($wherelist)->paginate($perPage);;

        return Response::json(['leads' => $leads]);
    }
    public function show(Request $request, $id)
    {
        $lead = USLead::with([
            'source',
            'loan',
            'applicant',
            'residence',
            'expense',
            'bank',
            'consent'])->where('id', $id)->first();


        return Response::json(['lead' => $lead]);
    }


    /**
     * This function accepts applications and posts/maps them to the DB.
     *
     * @param LeadPostRequestUS $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function post(LeadPostRequestUS $request)
    {


//        dd($request->input());
//        $ip = $request->ip();
//        $userAgent = $request->server('HTTP_USER_AGENT');

        if ($request->isJson()) {
            $post = json_decode($request->getContent());
            Log::debug('DEBUG::', (array)$post);
        }

        if ($post->vid == null) {
            return response('AFF ID is required', 300);
        }
        if ($post->oid == null) {
            $post->oid = 1;
        }

//        $startTime = explode(' ', microtime());
//        $startTime = $startTime[1] + $startTime[0];

        // Retrieve Partner Account Status if VID present.
//        dd($post);
        $this->partner_detail = Partner::GetPartnerFullDetail($post->vid, $this->leadtype);
        Log::debug('Partner_vendor::', (array)$this->partner_detail);
        if ($this->partner_detail === null) {
            echo 'Partner Not Active';
            die();
        }

        // Mapping + Add Lead to Database
        $post = $this->store($post);


        // Check for duplicates and limits setup up against affiliates.
//        $partner_limits = (new LmsPartnerLeadType)->partner_limits($request, $this->partner_detail, $this->leadtype);
//
//        if (!$partner_limits instanceof Request) {
//            echo $partner_limits;
//            die();
//        }
        // Add the Log to partner lead type table
        Log::debug('AFF ID::', (array)$this->partner_detail);
        $data['vendor_id'] = $this->partner_detail->vendor_id;
        $data['post_data'] = json_encode($post);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['lead_id'] = USLead::latest()->first()->id;
        $partner_log = USLead::add_log_partner($data);
        $partnerlogid = $partner_log->id;

//        dd($post);

        // Get Generated Lead ID and log it to Telescope
        $post->lead_id = DB::table('us_leads')->latest()->first()->id;
        Log::info('TestMode: ' . isset($post->istest) ?? $post->istest);
        Log::info('Lead ID: ' . $post->lead_id);



        //       **** IPQualityScore - Fraud Scoring ****

//        // Email Validation
//        $email = $post->email;
//        $response = $this->ipqs_email($email);
//
        // IP / Bot Detection
//        $response = $this->ipqs_ip($ipAddress, $userAgent);
//        $res = USLead::quality_check($response, $post->leadid);


        Log::debug('RESP TYPE::', (array)$post->response_type);
        if (isset($post->response_type)) {
            $response_type = $post->response_type;
        } else {
            $response_type = 'xml';
        }

        // Status Check Code
//        dd($post);
        $inputs = $post;
        $status_check = new CheckStatus();
        $status_check->lead_id = $post->uuid;
        $status_check->status = "pending";
        $status_check->percentage = 0;
        $status_check->correlationId = Str::uuid();
        $status_check->save();

        // Passing all required parameters to Job to get processed.
        $post = $post->toArray();
        $inputs = $inputs->toArray();
        $partner_detail = $this->partner_detail;
        $partnerlogid = $partnerlogid;
//        $data = $data;
//        $status_check = $status_check->toArray();

        PostLeadToBuyersUS::dispatch( $post, $inputs, $partner_detail, $partnerlogid, $data, $status_check);
        $resp = $this->curl_response_status($status_check, $response_type);
        echo $resp;
        die();
    }

    /**
     * @param $post
     * @return USLead
     */
    public function store($post)
    {


        $data = new USLead();
//        $data->id = Str::uuid();
        $data->uuid = Str::uuid();
        $data->vid = $this->toString($post->vid);
        $data->subid = $this->toString($post->subid);
        $data->oid = $this->toString($post->oid);
        $data->tier = $this->toString($post->tier ?? null);
        $data->transaction_id = $this->toString($post->transaction_id ?? null);

        if ($post->minCommissionAmount == '') {
            $post->minCommissionAmount = '0.00';
        }
        if ($post->maxCommissionAmount == '') {
            $post->maxCommissionAmount = '0.00';
        }
        $data->minCommissionAmount = $this->toString($post->maxCommissionAmount ?? '0.00');
        $data->maxCommissionAmount = $this->toString($post->maxCommissionAmount ?? '0.00');
        $data->timeout = $this->toString($post->timeout ?? null);
        $data->istest = $this->toString($post->istest ?? false);
        $data->response_type = $this->toString($post->response_type ?? 'json');
        $data->quote_boost = $this->toString($post->quote_boost ?? '0');
        $res = $data->save();


//        $source = (object)$post->source;
        $data->Source = new Source();
        $data->Source->id = $data->Source->id;
        $data->Source->lead_id = $data->uuid;
        $data->Source->ipAddress = $this->toString($post->source->ipAddress ?? '');
        $data->Source->userAgent = $this->toString($post->source->userAgent ?? '');
        $data->Source->creationUrl = $this->toString($post->source->creationUrl ?? '');
        $data->Source->referringUrl = $this->toString($post->source->referringUrl ?? '');
        $data->Source->save();

        $data->Loan = new Loan();
        $data->Loan->id = $data->Loan->id;
        $data->Loan->lead_id = $data->uuid;
        $data->Loan->loanPurpose = $this->toString($post->loan->loanPurpose ?? '');
        $data->Loan->loanAmount = $this->toString($post->loan->loanAmount ?? '');
        $data->Loan->loanTerms = $this->toString($post->loan->loanTerms ?? '');
        $data->Loan->recentLoanCount = $this->toString($post->loan->recentLoanCount ?? 0);
        $data->Loan->save();

//        Log::debug('POST->APPLICANT::', (array)$post->applicant);
        $data->Applicant = new Applicant();
        $data->Applicant->id = $data->Applicant->id;
        $data->Applicant->lead_id = $data->uuid;
        $data->Applicant->nameTitle = $this->toString($post->applicant->nameTitle ?? '');
        $data->Applicant->firstName = $this->toString($post->applicant->firstName ?? '');
        $data->Applicant->lastName = $this->toString($post->applicant->lastName ?? '');
        $data->Applicant->dateOfBirthDay = $this->toString($post->applicant->dateOfBirthDay ?? '');
        $data->Applicant->dateOfBirthMonth = $this->toString($post->applicant->dateOfBirthMonth ?? '');
        $data->Applicant->dateOfBirthYear = $this->toString($post->applicant->dateOfBirthYear ?? '');
        $data->Applicant->email = $this->toString($post->applicant->email ?? '');
        $data->Applicant->gender = $this->toString($post->applicant->gender ?? '');
        $data->Applicant->mobilePhoneNumber = $this->toString($post->applicant->mobilePhoneNumber ?? '');
        $data->Applicant->homePhoneNumber = $this->toString($post->applicant->homePhoneNumber ?? '');
        $data->Applicant->workPhoneNumber = $this->toString($post->applicant->workPhoneNumber ?? '');
        $data->Applicant->maritalStatus = $this->toString($post->applicant->maritalStatus ?? '');
        $data->Applicant->dependants = $this->toString($post->applicant->dependants ?? '0');
        $data->Applicant->save();


        $data->Residence = new Residence();
        $data->Residence->id = $data->Residence->id;
        $data->Residence->lead_id = $data->uuid;
        $data->Residence->houseNumber = $this->toString($post->residence->houseNumber ?? '');
        $data->Residence->houseName = $this->toString($post->residence->houseName ?? '');
        $data->Residence->flatNumber = $this->toString($post->residence->flatNumber ?? '');
        $data->Residence->addressStreet1 = $this->toString($post->residence->addressStreet1 ?? '');
        $data->Residence->addressStreet2 = $this->toString($post->residence->addressStreet2 ?? '');
        $data->Residence->city = $this->toString($post->residence->city ?? '');
        $data->Residence->county = $this->toString($post->residence->county ?? '');
        $data->Residence->zip = $this->toString($post->residence->zip ?? '');
        $data->Residence->residentialStatus = $this->toString($post->residence->residentialStatus ?? '');
        $data->Residence->monthsAtAddress = $this->toString($post->residence->monthsAtAddress ?? '');
        $data->Residence->numberOfAdults = $this->toString($post->residence->numberOfAdults ?? 0);
        $data->Residence->typeOfHousing = $this->toString($post->residence->typeOfHousing ?? 0);
        $data->Residence->numberOfRenters = $this->toString($post->residence->numberOfRenters ?? 0);
        $data->Residence->save();

//        $post = (object)$post->employer;
        $data->Employer = new Employer();
        $data->Employer->id = $data->Employer->id;
        $data->Employer->lead_id = $data->uuid;
        $data->Employer->employerName = $this->toString($post->employer->employerName ?? '');
        $data->Employer->jobTitle = $this->toString($post->employer->jobTitle ?? '');
        $data->Employer->monthsAtEmployer = $this->toString($post->employer->monthsAtEmployer ?? '');
        $data->Employer->employerIndustry = $this->toString($post->employer->employerIndustry ?? '');
        $data->Employer->incomeSource = $this->toString($post->employer->incomeSource ?? '');
        $data->Employer->incomeCycle = $this->toString($post->employer->incomeCycle ?? '');
        $data->Employer->monthlyIncome = $this->toString($post->employer->monthlyIncome ?? '');
        $data->Employer->combinedMonthlyHouseholdIncome = $this->toString($post->employer->combinedMonthlyHouseholdIncome ?? null);
        $data->Employer->nextPayDateDay = $this->toString($post->employer->nextPayDateDay ?? '');
        $data->Employer->nextPayDateMonth = $this->toString($post->employer->nextPayDateMonth ?? '');
        $data->Employer->nextPayDateYear = $this->toString($post->employer->nextPayDateYear ?? '');
        $data->Employer->followingPayDateDay = $this->toString($post->employer->followingPayDateDay ?? '');
        $data->Employer->followingPayDateMonth = $this->toString($post->employer->followingPayDateMonth ?? '');
        $data->Employer->followingPayDateYear = $this->toString($post->employer->followingPayDateYear ?? '');
        $data->Employer->incomePaymentType = $this->toString($post->employer->incomePaymentType ?? '');
        $data->Employer->governmentBenefitsAmount = $this->toString($post->employer->governmentBenefitsAmount ?? 0);
        $data->Employer->pensionAmount = $this->toString($post->employer->pensionAmount ?? 0);
        $data->Employer->otherIncomeAmount = $this->toString($post->employer->otherIncomeAmount ?? 0);
        $data->Employer->save();

        $data->Expense = new Expenses();
        $data->Expense->id = $data->Expense->id;
        $data->Expense->lead_id = $data->uuid;
        $data->Expense->foodExpense = $this->toString($post->bank->foodExpense ?? 0);
        $data->Expense->transportExpense = $this->toString($post->bank->transportExpense ?? 0);
        $data->Expense->childCareExpense = $this->toString($post->bank->childCareExpense ?? 0);
        $data->Expense->creditExpense = $this->toString($post->bank->creditExpense ?? 0);
        $data->Expense->otherExpense = $this->toString($post->bank->otherExpense ?? 0);
        $data->Expense->save();

        $data->Bank = new Bank();
        $data->Bank->id = $data->Bank->id;
        $data->Bank->lead_id = $data->uuid;
        $data->Bank->bankName = $this->toString($post->bank->bankName ?? '');
        $data->Bank->bankCardType = $this->toString($post->bank->bankCardType ?? '');
        $data->Bank->bankAccountNumber = $this->toString($post->bank->bankAccountNumber ?? '');
        $data->Bank->bankRoutingNumber = $this->toString($post->bank->bankRoutingNumber ?? '');
        $data->Bank->bankPhone = $this->toString($post->bank->bankPhone ?? '');
        $data->Bank->bankAccountLength = $this->toString($post->bank->bankAccountLength ?? '');
        $data->Bank->bankAccountType = $this->toString($post->bank->bankAccountType ?? '');
        $data->Bank->onlineBanking = $this->toString($post->bank->onlineBanking ?? '');
        $data->Bank->save();

        $data->Consent = new Consent();
        $data->Consent->id = $data->Consent->id;
        $data->Consent->lead_id = $data->uuid;
        $data->Consent->consentFinancial = $this->toString($post->consent->consentFinancial ?? '0');
        $data->Consent->consentCreditSearch = $this->toString($post->consent->consentCreditSearch ?? '0');
        $data->Consent->consentThirdPartyEmails = $this->toString($post->consent->consentThirdPartyEmails ?? '0');
        $data->Consent->consentThirdPartySMS = $this->toString($post->consent->consentThirdPartySMS ?? '0');
        $data->Consent->consentThirdPartyPhone = $this->toString($post->consent->consentThirdPartyPhone ?? '0');
        $data->Consent->save();

//        if (isset($data->Additonial)) {
//
//            $data->Additional = new Additional();
//            $data->Additional->id = $data->Additional->id;
//            $data->Additional->lead_id = $data->id;
//            $data->Additional->bestTimeToCall = $this->toString($post->additional->bestTimeToCall ?? '');
//            $data->Additional->creditScore = $this->toString($post->additional->creditScore ?? '');
//            $data->Additional->isCarOwner = $this->toString($post->additional->isCarOwner ?? '');
//            $data->Additional->bankruptcy = $this->toString($post->additional->bankruptcy ?? '');
//            $data->Additional->cosigner = $this->toString($post->additional->cosigner ?? '');
//            $data->Additional->ref_first_name_1 = $this->toString($post->additional->ref_first_name_1 ?? '');
//            $data->Additional->ref_last_name_1 = $this->toString($post->additional->ref_last_name_1 ?? '');
//            $data->Additional->ref_phone_1 = $this->toString($post->additional->ref_phone_1 ?? '');
//            $data->Additional->ref_relation_1 = $this->toString($post->additional->ref_relation_1 ?? '');
//            $data->Additional->ref_first_name_2 = $this->toString($post->additional->ref_first_name_2 ?? '');
//            $data->Additional->ref_last_name_2 = $this->toString($post->additional->ref_last_name_2 ?? '');
//            $data->Additional->ref_phone_2 = $this->toString($post->additional->ref_phone_2 ?? '');
//            $data->Additional->ref_relation_2 = $this->toString($post->additional->ref_relation_2 ?? '');
//            $data->Additional->save();
//        }

//        dd($data);

        $data_update = USLead::latest()->first();
//        $data_update = USLead::find($data['id']);
//        dd($data_update);
        $data_update->loan_id = $data->Loan->id;
        $data_update->source_id = $data->Source->id;
        $data_update->applicant_id = $data->Applicant->id;
        $data_update->residence_id = $data->Residence->id;
        $data_update->employer_id = $data->Employer->id;
        $data_update->expense_id = $data->Expense->id;
        $data_update->bank_id = $data->Bank->id;
        $data_update->consent_id = $data->Consent->id;
        if (isset($data->Additional)) {
            $data_update->additional_id = $data->Additional->id;
        }
        $res = $data_update->save();

        return $data;

    }


    /**
     * @param $val
     * @return false|string
     */
    private function toString($val)
    {
        if (gettype($val) == 'object' || gettype($val) == 'array') {
            $res = json_encode($val);
        } else {
            return $val;
        }

        return $res;
    }


    /**
     * Return Curl Response in XML | JSON.
     * @param $check_status
     * @param $response_type
     * @return false|string
     */
    function curl_response_status($check_status, $response_type = 'json')
    {
//        dd($check_status);
        $url = route('api-check-status', $check_status['correlationId']);
        $response_type = 'json';

        if (isset($response_type) && $response_type == 'xml') {
            header("Content-type: text/xml; charset=utf-8");
            $res = '<?xml version="1.0"?>';
            $res .= '<PostResponse>';
            $res .= '<PercentageComplete>' . $check_status['percentage'] . '</PercentageComplete>';
            $res .= '<CheckStatusID>' . $check_status['correlationId'] . '</CheckStatusID>';
            $res .= '<CheckStatus>' . $check_status['status'] . '</CheckStatus>';
            $res .= '<CheckStatusURL>' . $url . '</CheckStatusURL>';
            $res .= '</PostResponse>';

            return $res;
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $response = array();
            $response[0] = array(
                'PercentageComplete' => $check_status['percentage'],
                'CheckStatusID' => $check_status['correlationId'],
                'CheckStatus' => $check_status['status'],
                'CheckStatusURL' => $url,
            );
            return json_encode($response);
        }
    }


    /**
     * Randomize Buyer every N posts
     * @param $row
     * @param string $type
     * @return mixed|object
     */
    public function GetBuyerObject($row, string $type = 'lead_post')
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

            $v = Mapping::GetSingleBuyer($search);
            $row = (object)$v[0];
        }

        return $row;
    }

    /**
     * This function handles the redirect for the check status
     *
     * @param $id
     */
    public function redirecturl($id)
    {

        $CheckStatusLogger = new CheckStatusLogger;
        $api_received_at = Carbon::now()->microsecond;


        $data['id'] = $this->redirecturl_decrypt($id);

        $data['created_at'] = date('Y-m-d H:i:s', strtotime('-15 minutes'));
        $redirecturl = (new USLead)->UpdateRedirectUrl($data);

        if ($redirecturl) {
            header("location: " . $redirecturl);
            exit;
        } else {
            echo 'Invalid/Expired Redirect URL';
            exit;
        }
    }


    /**
     * This function handles the redirection url ( decrypt )
     * @param $id
     * @return string
     */
    public function redirecturl_decrypt($id)
    {
        return $unsecure = substr(substr($id, 2), 0, -2);
    }

    /**
     * This function will check for tiers
     *
     * @param $str
     * @return bool
     */
    public function tier_check($str)
    {
        if (!array_key_exists($str, config('array.paydayus_tiers'))) {

            echo 'tier_check', 'The %s field value is out of the given list.';

            return false;
        } else {
            return true;
        }
    }

    /**
     * This function calls the IPQS curl post
     * @param $email
     * @return mixed
     */
    public function ipqs_email($email)
    {
        $ipqs = config('ipqs');
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

        return CurlHelper::ipqs_ip(
            $url,
            $key,
            $email,
            $formatted_parameters
        );

    }

    /**
     * @param $ip
     * @param $user_agent
     * @return mixed
     */
    public function ipqs_ip($ip, $user_agent)
    {
        $ipqs = config('ipqs');
        $key = $ipqs[0];
        $timeout = $ipqs[1];
        $fast = $ipqs[2];
        $abuse_strictness = $ipqs[3];

        $ipqs_ip_url = 'https://ipqualityscore.com/api/json/ip/' . $key . '/' . $ip . '?strictness=1&user_agent=' . $user_agent;


        return CurlHelper::ipqs_ip(
            $ipqs_ip_url,
            $timeout,
        );
    }

    /**
     *
     * @param Request $request
     */
    public function last_check_status(Request $request)
    {
        dd($request);

        $CheckStatusLogger = new CheckStatusLogger;
        $check_status_id = $request->input('id');

        Log::debug('DEBUG: Check Status ID is numeric: ' . (is_numeric($check_status_id)));


        if (is_numeric($check_status_id)) {
            $CheckStatusLogger->updateStatus($check_status_id,
                [
                    'response_affiliate_received_at' => $request->input('response_affiliate_received_at'),
                    'response_affiliate_issued_at' => $request->input('response_affiliate_issued_at'),
                    'response_client_received_at' => $request->input('response_client_received_at')
                ]);
        }
    }

    /**
     * This function handles the new check status,
     * checks against the check status id.
     *
     * @param Request $request
     * @param $correlationId
     */
    public function CheckStatusNew(Request $request, $correlationId)
    {
        $status_check = CheckStatus::where('correlationId', '=', $correlationId)->first();
        $lead = USLead::where('uuid', '=', $status_check->lead_id)->first();
//        dd($lead->response_type);
//        $response_type = 'json';
        $response_type = $lead->response_type;

        if (isset($response_type) && $response_type === 'xml') {
            if ($status_check->status == 'pending') {
                echo $this->curl_response_status($status_check, $response_type);
            } else {
                header("Content-type: text/xml; charset=utf-8");
                echo $status_check->resp;
            }
            Log::info('DEBUG:: Check Status ID', (array)$correlationId);
        } else {
//            $lead = USLead::where('id', '=', $status_check->lead_id)->first();
            $response_type = $lead->response_type;

            if ($status_check->status == 'pending') {
                echo $this->curl_response_status($status_check, $response_type);
            } else {
                header("Content-type: application/json; charset=utf-8");
                echo $status_check->resp;
            }
            Log::info('DEBUG:: Check Status ID', (array)$correlationId);
        }
        die();
    }


    /*
     * This function checks the last check status ->  OLD check status
     *
     */

    public function CheckStatus(Request $request)
    {
        dd($request);
        $CheckStatusLogger = new CheckStatusLogger;
        $check_status_id = $request->input('id');

        Log::debug('DEBUG: Check Status ID is numeric: ' . print_r(is_numeric($check_status_id), true));

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

        Log::debug('DEBUG: CHECK STATUS LEAD ID ' . $leadid);

        // Fetch the status of the lead ID from the DB
        $res = USLead::CheckStatus($leadid);
        $post_response = $res[0]->post_response;

        // Get log ID from the DB using lead ID
        $partnerlogid = USLead::FindPartnerLogId($leadid);
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
                $res_log = (new USLead)->UpdateLog($datalogo);
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
                $res = (new USLead)->add($data);


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
//                    Lmscallcenter::AddLeadType($lead_data);


                    // Rev-share
                } elseif ($offerid == 2) {
                    $response['Threshold'] = 'true';
                    $response['ThresholdAmount'] = $price;
                }
                if ($this->partner_detail->currencyType != 1) {
                    $rate = USLead::GetDailyRate();
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
                $res_pub = USLead::add_log_partner($data_pub);

                Log::debug('DEBUG: CHECK STATUS LEAD ID ' . $leadid . ': Final response: ' . print_r($post_response, true));

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

                Log::debug('DEBUG: CHECK STATUS LEAD ID ' . $leadid . ': Final response: ' . print_r($post_response, true));


                print_r($post_response);
                die;
            }
        }
    }

    /**
     * Return Curl Response in XML | JSON
     * @param $client_response
     * @param $response_type
     * @return false|string
     */
    function curl_response_post($client_response, $response_type)
    {
        if (isset($response_type) && $response_type === 'xml') {
            header("Content-type: text/xml; charset=utf-8");
            $res = '<?xml version="1.0"?>';
            $res .= '<PostResponse>';

            if (isset($client_response['status']) && $client_response['status'] === 1) {
                $res .= '<Response>LenderFound</Response>';

            } elseif (isset($client_response['status']) && $client_response['status'] === 3) {
                $res .= '<Response>ConditionalLenderFound</Response>';
            } else {
                $res .= '<Response>NoLenderFound</Response>';
            }
            $res .= ($client_response['status'] == '1') ? '<Price>' . $client_response['price'] . '</Price>' : '';
            $res .= ($client_response['status'] == '3') ? '<Price>' . $client_response['price'] . '</Price>' : '';
            $res .= ($client_response['status'] == '1' || '2' || '3') ? '<Leadid>' . $client_response['leadid'] . '</Leadid>' : '<Leadid>' . $client_response['leadid'] . '</Leadid>';
            $res .= ($client_response['status'] == '1') ? '<RedirectURL>' . 'https://portal.uping.co.uk/api/application/redirecturl/' . $this->redirecturl_encrypt($client_response['leadid']) . '</RedirectURL>' : '';
            $res .= ($client_response['status'] == '1' && !empty($client_response['Threshold'])) ? '<Threshold>' . $client_response['Threshold'] . '</Threshold>' : '';
            if ($client_response['status'] && $client_response['ModelType'] === '1') {
                $res .= '<ModelType>CPS</ModelType>';
            } elseif (isset($client_response['status']) && $client_response['ModelType'] === '2') {
                $res .= '<ModelType>CPA</ModelType>';
            } elseif (isset($client_response['status']) && $client_response['ModelType'] === '3') {
                $res .= '<ModelType>CPL</ModelType>';
            } elseif (isset($client_response['status']) && $client_response['ModelType'] === '4') {
                $res .= '<ModelType>CPF</ModelType>';
            } else {
                $res .= '<ModelType>Pingtree</ModelType>';
            }
            $res .= ($client_response['status'] == '2') ? '<Descriptions>' . $client_response['Descriptions'] . '</Descriptions>' : '';
            $res .= isset($client_response['errors']) ? '<Errors>' . $client_response['errors'] . '</Errors>' : '';
            $res .= '</PostResponse>';
            return $res;
        } else {
            header("Content-type: application/json; charset=utf-8");
            $response = array();
            $response[0] = array(
                'Response' => ($client_response['status'] == '1') ? 'LenderFound' : 'NoLenderFound',
                'Price' => ($client_response['status'] == '1') ? $client_response['price'] : '',
                'RedirectURL' => ($client_response['status'] == '1') ? 'https://portal.uping.co.uk/api/application/redirecturl/' . $this->redirecturl_encrypt($client_response['leadid']) : '',
                'Leadid' => ($client_response['status'] == '1' || '2') ? $client_response['leadid'] : '',
//                'CheckStatusID' => $client_response['check_status_id'] ?? '',
//                'PostbackMethod' => $client_response['postback_method'] ?? '',
//                'IframeURL' => $client_response['iframe_url'] ?? '',
            );
            if ($client_response['status'] && $client_response['ModelType'] === '1') {
                $response[0] = array_merge($response[0], ['ModelType' => 'CPS']);
            } elseif (isset($client_response['status']) && $client_response['ModelType'] === '2') {
                $response[0] = array_merge($response[0], ['ModelType' => 'CPA']);
            } elseif (isset($client_response['status']) && $client_response['ModelType'] === '3') {
                $response[0] = array_merge($response[0], ['ModelType' => 'CPL']);
            } elseif (isset($client_response['status']) && $client_response['ModelType'] === '3') {
                $response[0] = array_merge($response[0], ['ModelType' => 'CPF']);
            } else {
                $response[0] = array_merge($response[0], ['ModelType' => 'Pingtree']);
            }

            if ($client_response['status'] == '1' && (!empty($client_response['CheckStatusID']))) {
                $response[0] = array_merge($response[0], ['CheckStatusID' => $client_response['CheckStatusID']]);
            }
            if ($client_response['status'] == '1' && !empty($client_response['Threshold'])) {
                $response[0] = array_merge($response[0], ['Threshold' => $client_response['Threshold']]);
            }
            if (isset($client_response['Descriptions']) && !empty($client_response['Descriptions'])) {
                $response[0] = array_merge($response[0], ['Descriptions' => $client_response['Descriptions']]);
            }
            if (isset($client_response['Errors']) && !empty($client_response['Errors'])) {
                $response[0] = array_merge($response[0], ['Errors' => $client_response['Errors']]);
            }
            if (isset($client_response['CheckStatus']) && !empty($client_response['CheckStatus'])) {
                $response[0] = array_merge($response[0], ['CheckStatus' => $client_response['CheckStatus']]);
            }
            return json_encode($response);
        }
    }


    /**
     * @param $id
     * @return string
     */
    public function redirecturl_encrypt($id)
    {

        $secure = rand(10, 99) . $id . rand(10, 99);
//        return
    }


    /**
     * @param Request $request
     * @param $buyer_token
     * @param $correlationId
     */
    public function mark_cpf_funded(Request $request, $buyer_token, $correlationId)
    {
        if (isset($buyer_token)) {
            try {
                $valid_token = BuyerAccessToken::where('token', '=', $buyer_token)->get();
                if ($valid_token->isEmpty()) {
                    abort(403, 'Not Authorized');
                }
            } catch (Exception $e) {
                abort(403, 'Not Authorized');
            }

            $query = DB::table('lmspaydayuks')->where('id', $correlationId);

            $lead = $query->first();
            $tier = Buyersetup::find($lead->buyerTierID)->first();

            $partner_detail = LmsPartnerLeadType::where('vid', $lead->vid)->first();

            $vidLeadPrice = $tier->tier_price - ($tier->tier_price * ($partner_detail->margin / 100));

            $res = $query->update([
                'leadStatus' => 4, // CPFFunded
                'vidLeadPrice' => $vidLeadPrice,
                'buyerLeadPrice' => $tier->tier_price,
                'updated_at' => Carbon::now(),
            ]);
            echo 'Success:: CPF Funded Received ';
        } else {
            abort(403, 'Not Authorized');
        }
    }

}
