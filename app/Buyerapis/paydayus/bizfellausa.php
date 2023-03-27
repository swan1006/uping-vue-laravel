<?php
//sleep(10);

use App\Helpers\CurlHelper;
use BizFellaUSA\Applicant;
use BizFellaUSA\Application;
use BizFellaUSA\Bank;
use BizFellaUSA\Consent;
use BizFellaUSA\Employment;
use BizFellaUSA\Loan;
use BizFellaUSA\Params;
use BizFellaUSA\Residence;
use BizFellaUSA\TestMode;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class bizfellausa
{
    var $response = array();
    //function __construct($client_detail, $post){
    //parent::__construct();

    function __construct($client_detail, $post)
    {
        $this->manageDependencies();

        $dob_day = $post->applicant->dateOfBirthDay;
        $dob_month = $post->applicant->dateOfBirthMonth;
        $dob_year = $post->applicant->dateOfBirthYear;

        if (strlen($dob_day) < 2) {
            $dob_day = '0' . $dob_day;
        }
        if (strlen($dob_month) < 2) {
            $dob_month = '0' . $dob_month;
        }

        if ($dob_month > '12') {
            $dateOfBirth = $dob_year . '-' . $dob_day . '-' . $dob_month;

        } else {
            $dateOfBirth = $dob_year . '-' . $dob_month . '-' . $dob_day;

        }



        $next_pay_date_day = $post->employer->nextPayDateDay;
        $next_pay_date_month = $post->employer->nextPayDateMonth;
        $next_pay_date_year = $post->employer->nextPayDateYear;
        $nextPayDate = $next_pay_date_year . '-' . $next_pay_date_month . '-' . $next_pay_date_day;

        $followingPayDateDay = $post->employer->followingPayDateDay;
        $followingPayDateMonth = $post->employer->followingPayDateMonth;
        $followingPayDateYear = $post->employer->followingPayDateYear;
        $followingPayDate = $followingPayDateYear . '-' . $followingPayDateMonth . '-' . $followingPayDateDay;

        $AddressMoveIn = floor($post->applicant->monthsAtAddress);
//        dd($AddressMoveIn);

        $ssn = str_replace('-', '', $post->applicant->ssn);

        // Time in current data->employment status
        $EmploymentStarted = floor($post->employer->monthsAtEmployer);

        // Time at bank
        $BankAccountOpened = floor($post->bank->bankAccountLength);

        $country = 'USA';
        $bestTimeToCall = 'Other';

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
                $post->residence->residentialStatus = 1;
            case 'PrivateTenant':
                $post->residence->residentialStatus = 0;
            case 'CouncilTenant':
                $post->residence->residentialStatus = 0;
            case 'LivingWithParents':
                $post->residence->residentialStatus = 0;
            case 'LivingWithFriends':
                $post->residence->residentialStatus = 0;
            case 'Other':
                $post->residence->residentialStatus = 0;
        }
        switch ($post->employer->incomeSource) {
            case 'SelfEmployed':
                $post->employer->incomeSource = 3;
            case 'EmployedFullTime':
                $post->employer->incomeSource = 1;
            case 'EmployedPartTime':
                $post->employer->incomeSource = 2;
            case 'EmployedTemporary':
                $post->employer->incomeSource = 4;
            case 'Pension':
                $post->employer->incomeSource = 5;
            case 'DisabilityBenefits':
                $post->employer->incomeSource = 6;
            case 'Benefits':
                $post->employer->incomeSource = 6;
            case 'Unemployed':
                $post->employer->incomeSource = 7;
            case 'Student':
                $post->employer->incomeSource = 8;
        }
        switch ($post->employer->incomeCycle) {
            case 'Weekly':
                $post->employer->incomeCycle = 1;
            case 'BiWeekly':
                $post->employer->incomeCycle = 2;
            case 'TwiceMonthly':
                $post->employer->incomeCycle = 3;
            case 'FourWeekly':
                $post->employer->incomeCycle = 4;
            case 'Monthly':
                $post->employer->incomeCycle = 4;
            case 'LastWorkingDayMonth':
                $post->employer->incomeCycle = 4; // change

        }
        switch ($post->employer->incomePaymentType) {
            case 'Cash':
                $post->employer->incomePaymentType = 0;
            case 'Cheque':
                $post->employer->incomePaymentType = 0;
            case 'RegionalDirectDeposit':
                $post->employer->incomePaymentType = 1;
            case 'NonRegionalDirectDeposit':
                $post->employer->incomePaymentType = 0;
        }
        switch ($post->bank->bankAccountType) {
            case 'Checking':
                $post->bank->bankAccountType = 1;
            case 'Savings':
                $post->bank->bankAccountType = 2;

        }

        $json = array(
            "channel_key" => (string)$client_detail->parameter1,
//            "min_price" => (float)$client_detail->min_price,
//            "max_price" => (float)$client_detail->max_price,
            "response_type" => 'json',
            "timeout" => (int)$client_detail->timeout,

            "testmode" => array(
                "active" => (boolean)0,
                "response_type" => 'json',
            ),
            "params" => array(
                "user_ip" => (string)$post->source->ipAddress,
                "form_url" => (string)$post->source->creationUrl,
                "referer_url" => (string)$post->source->referringUrl,
                "user_agent" => (string)$post->source->userAgent,
            ),
            "data" => array(
                "loan" => array(
                    "amount" => (int)$post->loan->loanAmount,
                    "purpose" => (int)$post->loan->loanPurpose,
                    "term" => (int)$post->loan->loanTerms,
                ),
                "applicant" => array(
                    "first_name" => (string)$post->applicant->firstName,
                    "last_name" => (string)$post->applicant->lastName,
                    "drivers_license_number" => (string)$post->applicant->drivingLicenseNumber,
                    "drivers_license_state" => (string)$post->applicant->drivingLicenseState,
                    "ssn" => (string)$ssn,
                    "birth_date" => (string)$dateOfBirth,
                    "email" => (string)$post->applicant->email,
                    "home_phone" => (string)$post->applicant->homePhoneNumber,
                    "cell_phone" => (string)$post->applicant->cellPhoneNumber,
                    "work_phone" => (string)$post->applicant->workPhoneNumber,
                    "military" => (boolean)$post->applicant->inMilitary,
                ),
                "residence" => array(
                    "state" => (string)$post->residence->state,
                    "city" => (string)$post->residence->city,
                    "zip" => (string)$post->residence->zip,
                    "address" => (string)$post->residence->addressStreet1,
                    "own_home" => (bool)$post->residence->residentialStatus,
                    "months_at_address" => (int)$AddressMoveIn,
                ),
                "employment" => array(
                    "employer" => (string)$post->employer->employerName,
                    "job_title" => (string)$post->employer->jobTitle,
                    "income_type" => (int)$post->employer->incomeSource,
                    "monthly_income" => (int)$post->employer->monthlyIncome,
                    "next_pay_date" => (string)$nextPayDate,
                    "following_pay_date" => (string)$followingPayDate,
                    "pay_frequency" => (int)$post->employer->incomeCycle,
                    "direct_deposit" => (bool)$post->employer->incomePaymentType,
                ),
                "bank" => array(
                    "bank_name" => (string)$post->bank->bankName,
                    "account_length" => (int)$BankAccountOpened,
                    "routing_number" => (string)$post->bank->bankRoutingNumber,
//                    "routing_number" => (string)'256074974',
                    "account_number" => (string)$post->bank->bankAccountNumber,
                    "account_type" => (int)$post->bank->bankAccountType,
                ),
                "consent" => array(
                    "credit_check" => (bool)$post->consent->consentFinancial,
                    "remarketing_email" => (bool)$post->consent->consentThirdPartyEmails,
                    "remarketing_phone" => (bool)$post->consent->consentThirdPartyPhone,
                    "remarketing_sms" => (bool)$post->consent->consentThirdPartySMS,
                ),
            ),
        );

        Log::debug('BizFellaUSA::', (array) $json);

//        dd(json_encode($application));
//        dd($post);
        $this->response['post_data'] = $json;
        $this->response['header'] = array(
            'Accept: application/json, text/javascript, *.*',
            'Content-type: application/json; charset=utf-8'
        );
        $this->response['timeout'] = $client_detail->timeout;
        $this->response['post_url'] = ($client_detail->status == '0') ? $client_detail->post_url_test : $client_detail->post_url_live;
        $this->response['validated'] = true;

        $validation_result = true;
        if ($validation_result == true) {

            $application_status = (new App\Helpers\CurlHelper)->curl_post(
                $this->response['post_url'],
                $this->response['post_data'],
                $this->response['header'] = array(
                    'Accept: application/json, text/javascript, *.*',
                    'Content-Type: application/json; charset=utf-8'
                ),
                $this->response['timeout']
            );
            Log::debug('RESP POST::', (array)$application_status);
            $this->response['application_response'] = (array)$application_status;

        } else {
            $this->response['application_response'] = $validation_result;
            $this->response['validated'] = false;
        }
//        Log::debug('RESP::', (array) $application_status);
    }

    private function manageDependencies()
    {
        require_once dirname(__DIR__) . '/vendor/BizFellaUSA/Application.php';
        require_once dirname(__DIR__) . '/vendor/BizFellaUSA/Params.php';
        require_once dirname(__DIR__) . '/vendor/BizFellaUSA/Applicant.php';
        require_once dirname(__DIR__) . '/vendor/BizFellaUSA/Employment.php';
        require_once dirname(__DIR__) . '/vendor/BizFellaUSA/Consent.php';
        require_once dirname(__DIR__) . '/vendor/BizFellaUSA/Residence.php';
        require_once dirname(__DIR__) . '/vendor/BizFellaUSA/Loan.php';
        require_once dirname(__DIR__) . '/vendor/BizFellaUSA/Bank.php';
        require_once dirname(__DIR__) . '/vendor/BizFellaUSA/Status.php';
        require_once dirname(__DIR__) . '/vendor/BizFellaUSA/TestMode.php';
        require_once dirname(__DIR__) . '/vendor/autoload.php';
        require_once dirname(__DIR__) . '/vendor/BizFellaUSA/ExtendedValidator.php';
    }

    public function returnresponse()
    {
        $appResponse = $this->response['application_response'];
        Log::debug('APP RESP::', (array)$appResponse);

        $resp_data = json_decode((string)$appResponse['res']);
        Log::debug('DEBUG::', (array)$resp_data);

        $this->response['post_res'] = json_encode($resp_data);
        Log::debug('RESP2 :: ', (array)$this->response);

        if ($resp_data->status === 'data_error') {
            $this->response['accept'] = 'Validation Failed';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
            return $this->response;
        }

        if ($resp_data->status == 'sold') {
            $this->response['accept'] = 'ACCEPTED';
            $this->response['post_price'] = $resp_data->price;
            $this->response['post_status'] = '1';
            $this->response['redirect_url'] = $resp_data->redirect;
//                $this->response['post_time'] = $appResponse['post_time'];
        } else {
            $this->response['accept'] = 'REJECTED';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
            $this->response['post_time'] = $appResponse['post_time'];
        }
        return $this->response;
    }

}
