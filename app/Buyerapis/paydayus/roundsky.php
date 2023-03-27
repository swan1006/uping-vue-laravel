<?php

use App\Helpers\CurlHelper;
use Illuminate\Support\Str;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class roundsky
{
    var $response = array();
    //function __construct($client_detail, $post){
    //parent::__construct();

    function __construct($client_detail, $post)
    {


        $dob_day = $post->applicant->dateOfBirthDay;
        $dob_month = $post->applicant->dateOfBirthMonth;
        $dob_year = $post->applicant->dateOfBirthYear;
        $dateOfBirth = $dob_year . '-' . $dob_month . '-' . $dob_day;

        $next_pay_date_day = $post->employer->nextPayDateDay;
        $next_pay_date_month = $post->employer->nextPayDateMonth;
        $next_pay_date_year = $post->employer->nextPayDateYear;
        $nextPayDate = $next_pay_date_year . '-' . $next_pay_date_month . '-' . $next_pay_date_day;

        $followingPayDateDay = $post->employer->followingPayDateDay;
        $followingPayDateMonth = $post->employer->followingPayDateMonth;
        $followingPayDateYear = $post->employer->followingPayDateYear;
        $followingPayDate = $followingPayDateYear . '-' . $followingPayDateMonth . '-' . $followingPayDateDay;

        $AddressMoveIn = floor($post->residence->stayYear * 12 + $post->residence->monthsAtAddress);

        // Time in current employment status
        $EmploymentStarted = floor($post->employer->monthsAtEmployer);

        $monthsAtBank = floor($post->bank->bankAccountLength);


        switch ($post->applicant->nameTitle) {
            case 'Mr':
                $post->applicant->nameTitle = 1;
            case 'Mrs':
                $post->applicant->nameTitle = 2;
            case 'Ms':
                $post->applicant->nameTitle = 3;
            case 'Miss':
                $post->applicant->nameTitle = 4;
        }
        switch ($post->employer->incomeSource) {
            case 'SelfEmployed':
                $post->employer->incomeSource = 'self_employed';
            case 'EmployedFullTime':
                $post->employer->incomeSource = 'employment';
            case 'EmployedPartTime':
                $post->employer->incomeSource = 'employment';
            case 'EmployedTemporary':
                $post->employer->incomeSource = 'employment';
            case 'Pension':
                $post->employer->incomeSource = 'employment';
            case 'DisabilityBenefits':
                $post->employer->incomeSource = 'benefits';
            case 'Benefits':
                $post->employer->incomeSource = 'benefits';
        }
        switch ($post->employer->incomeCycle) {
            case 'Weekly':
                $post->employer->incomeCycle = 'weekly';
            case 'BiWeekly':
                $post->employer->incomeCycle = 'bi_weekly';
            case 'TwiceMonthly':
                $post->employer->incomeCycle = 'twice_monthly';
            case 'FourWeekly':
                $post->employer->incomeCycle = 'monthly';
            case 'Monthly':
                $post->employer->incomeCycle = 'monthly';
        }
        switch ($post->employer->incomePaymentType) {
            case 'Cash':
                $post->employer->incomePaymentType = false;
            case 'Cheque':
                $post->employer->incomePaymentType = false;
            case 'RegionalDirectDeposit':
                $post->employer->incomePaymentType = true;
        }
        switch ($post->applicant->inMilitary) {
            case 'None':
                $post->applicant->inMilitary = 0;
            case 'Veteran':
                $post->applicant->inMilitary = 1;
            case 'Reserves':
                $post->applicant->inMilitary = 1;
            case 'ActiveDuty':
                $post->applicant->inMilitary = 1;
        }
        switch ($post->residence->residentialStatus) {
            case 'HomeOwner':
                $post->residence->residentialStatus = 'own';
            case 'PrivateTenant':
                $post->residence->residentialStatus = 'rent';
            case 'CouncilTenant':
                $post->residence->residentialStatus = 'rent';
            case 'LivingWithParents':
                $post->residence->residentialStatus = 'rent';
            case 'LivingWithFriends':
                $post->residence->residentialStatus = 'rent';
            case 'Other':
                $post->residence->residentialStatus = 'rent';

        }
        switch ($post->applicant->maritalStatus) {
            case 'Single':
                $post->applicant->maritalStatus = 1;
            case 'Married':
                $post->applicant->maritalStatus = 2;
            case 'LivingTogether':
                $post->applicant->maritalStatus = 3;
            case 'Separated':
                $post->applicant->maritalStatus = 4;
            case 'Divorced':
                $post->applicant->maritalStatus = 5;
            case 'Widowed':
                $post->applicant->maritalStatus = 6;
            case 'Other':
                $post->applicant->maritalStatus = 7;

        }
        switch ($post->bank->bankAccountType) {
            case 'Checking':
                $post->bank->bankAccountType = 'checkings';
            case 'Savings':
                $post->bank->bankAccountType = 'savings';

        }

        if (Str::startsWith($post->source->referringUrl, 'http')) {
            $input = $post->source->referringUrl;
            $new_input = preg_replace("#^[^:/.]*[:/]+#i", "", $input);
            $referringUrl = $new_input;
        } else {
            $referringUrl = $post->source->referringUrl;
        }


        $json = http_build_query(array(
                "time_allowed" => (int)120,
                "partner" => (string)$client_detail->parameter1,
                "partner_password" => (string)$client_detail->parameter2,
                "customer_ip" => (string)$post->source->ipAddress,
                "browser_info" => (string)$post->source->userAgent,
                "domain" => (string)$referringUrl,
                "response_type" => 'json',
                "tier" => (int)1,
//                "minimum_price" => (int)'',
                "sub_id" => (string)$post->subid ?? 'UPING',
                "first_name" => (string)$post->applicant->firstName,
                "last_name" => (string)$post->applicant->lastName,
                "email" => (string)$post->applicant->email,
                "birth_date" => (string)$dateOfBirth,
                "address" => (string)$post->residence->addressStreet1,
                "city" => (string)$post->residence->city,
                "state" => (string)$post->residence->state,
                "zip" => (string)$post->residence->zip,
                "home_phone" => (string)$post->applicant->homePhoneNumber,
                "work_phone" => (string)$post->applicant->workPhoneNumber,
                "housing" => (string)$post->residence->residentialStatus,
                "monthly_income" => (int)$post->employer->monthlyIncome,
                "direct_deposit" => $post->employer->incomePaymentType,
                "pay_period" => (string)$post->employer->incomeCycle,
                "next_pay_date" => (string)$nextPayDate,
                "second_pay_date" => (string)$followingPayDate,
                "months_at_residence" => (int)$AddressMoveIn,
                "requested_loan_amount" => (int)$post->loan->loanAmount,
                "income_type" => (string)$post->employer->incomeSource,
                "active_military" => (string)$post->applicant->inMilitary,
                "occupation" => (string)$post->employer->jobTitle,
                "employer" => (string)$post->employer->employerName,
                "months_employed" => (int)$EmploymentStarted,

                "bank_name" => (string)$post->bank->bankName,
                "account_type" => (string)$post->bank->bankAccountType,
                "account_number" => (string)$post->bank->bankAccountNumber,
                "routing_number" => (string)$post->bank->bankRoutingNumber,
                "driving_license_state" => (string)$post->applicant->drivingLicenseState,
                "driving_license_number" => (string)$post->applicant->drivingLicenseNumber,
                "social_security_number" => (string)$post->applicant->ssn,
            )
        );

        Log::debug('POST DATA::', (array)$json);

        $this->response['post_data'] = $json;
//        $this->response['header'] = array(
//            'Accept: application/json, text/javascript, *.*',
//            'Content-type: application/json; charset=utf-8'
//        );
        $this->response['timeout'] = $client_detail->timeout;
        $this->response['post_url'] = ($client_detail->status == '0') ? $client_detail->post_url_test : $client_detail->post_url_live;


        $validation_result = true;
        if ($validation_result == true) {

            $application_status = (new App\Helpers\CurlHelper)->http_post(
                $this->response['post_url'],
                $this->response['post_data'],
               '',
                $this->response['timeout']
            );
            Log::debug('RESP POST::', (array)$application_status);
            $this->response['application_response'] = (array)$application_status;

        } else {
            $this->response['application_response'] = $validation_result;
            $this->response['validated'] = false;
        }
    }

    function get_client_ip($ip)
    {
        $ipaddress = $ip;
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    function dd($parm = null)
    {
        echo '<pre>';
        print_r($parm);
        exit;

    }

    public function returnresponse()
    {

        $appResponse = $this->response['application_response'];
        Log::debug('APP RESP::', (array)$appResponse['res']);

        $resp_data = json_decode($appResponse['res']);
        Log::debug('DEBUG::', (array)$resp_data);

        $this->response['post_res'] = $resp_data;
        $this->response['post_time'] = $resp_data->post_time;

        Log::debug('RESP2 :: ', (array)$this->response);

        if ($resp_data->decision == 'APPROVED') {
            $this->response['accept'] = 'ACCEPTED';
            $this->response['post_price'] = $resp_data->price;
            $this->response['post_status'] = '1';
            $this->response['redirect_url'] = $resp_data->url;
            $this->response['post_time'] = $resp_data->post_time;


        } else {
            $this->response['accept'] = 'REJECTED';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
            $this->response['post_time'] = $resp_data->post_time;

        }
        //print_r($this->response);exit;
        return $this->response;
    }
}
