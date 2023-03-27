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


class bizfellauk
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
        $dateOfBirth = $dob_year . '-' . $dob_month . '-' . $dob_day;

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
            "channel_key" => (string)$client_detail->parameter1, // 608-10943-4-sXeYqAoJggBzxEsWq9SYv7fFX3NTjoLK
//            "min_price" => (float)$client_detail->min_price,
//            "max_price" => (float)$client_detail->max_price,
            "response_type" => 'json',
            "timeout" => (int)$client_detail->timeout,

            "testmode" => array(
                "active" => (boolean)1,
                "response_type" => 'json',
            ),
            "params" => array(
                "user_ip" => (string)$post->source->ipAddress,
                "form_url" => (string)$post->source->creationUrl,
                "referer_url" => (string)$post->source->referringUrl,
                "user_agent" => (string)$post->source->userAgent,
                "source" => 'TEST'
            ),
            "data" => array(
                "loan" => array(
                    "amount" => (int)$post->loan->loanAmount,
                    "purpose" => (int)$post->loan->loanPurpose,
                    "term" => (int)$post->loan->loanTerms,
                ),
                "applicant" => array(
                    "title" => (int) $post->applicant->nameTitle ?? 1,
                    "first_name" => (string)$post->applicant->firstName,
                    "last_name" => (string)$post->applicant->lastName,
                    "email" => (string)$post->applicant->email,
                    "home_phone" => (string)$post->applicant->homePhoneNumber,
                    "cell_phone" => (string)$post->applicant->mobilePhoneNumber,
                    "work_phone" => (string)$post->applicant->workPhoneNumber,
                    "birth_date" => (string)$dateOfBirth,
                    "marital_status" => (int)$post->applicant->maritalStatus,
                    "dependents" => (int)$post->applicant->numberOfDependants,
                ),
                "current_residence" => array(
                    "street" => (string)$post->residence->addressStreet1,
                    "house" => (string)$post->residence->houseNumber,
                    "county" => (string)$post->residence->county,
                    "town" => (string)$post->residence->city,
                    "postcode" => (string)$post->residence->postcode,
                    "status" => (int)$post->residence->residentialStatus,
                    "months_at_address" => (int)$AddressMoveIn,
                ),
                "employment" => array(
                    "type" => (int)$post->employer->incomeSource,
                    "employer_name" => (string)$post->employer->employerName,
                    "industry" => (int)$post->employer->employerIndustry,
                    "job_title" => (string)$post->employer->jobTitle,
                    "months_at_employer" => (int)$post->employer->monthsAtEmployer,
                    "monthly_income" => (int)$post->employer->monthlyIncome,
                    "pay_frequency" => (int)$post->employer->incomeCycle,
                    "payment_method" => (int)$post->employer->incomePaymentType,
                    "next_pay_date" => (string)$nextPayDate,
                    "following_pay_date" => (string)$followingPayDate,
                ),
                "income" => array(
                    "total_amount" => (int)$post->employer->monthlyIncome, //
                    "benefits_amount" => (int)$post->employer->governmentBenefitsAmount,
                    "pension_amount" => (int)$post->employer->pensionAmount,
                    "other_amount" => (int)$post->employer->otherIncomeAmount,
                ),
                "bank" => array(
                    "account_number" => (string)$post->bank->bankAccountNumber,
                    "account_type" => (int)$post->bank->bankAccountType,
                    "sort_code" => (string)$post->bank->bankRoutingNumber,
                    "debit_card" => (string)$post->bank->bankCardType,
                    "direct_deposit" => (string)$post->bank->direct_deposit,
                ),
                "expenses" => array(
                    "housing" => (int)$post->expense->monthlyMortgageRent,
                    "credit" => (int)$post->expense->creditExpense,
                    "utility" => (int)$post->expense->utlitiesExpense,
                    "food" => (int)$post->expense->foodExpense,
                    "transport" => (int)$post->expense->transportExpense,
                    "childcare" => (int)$post->expense->childCareExpense,
                    "insurance" => (int)$post->expense->insuranceExpense,
                    "other" => (int)$post->expense->otherExpense,
                ),
                "personal_finance" => array(
                    "recent_loans_taken_number" => (int)$post->loan->recentLoanAmount,
                ),
                "consent" => array(
                    "credit_check" => (bool)$post->consent->consentFinancial,
                    "remarketing_email" => (bool)$post->consent->consentThirdPartyEmails,
                    "remarketing_phone" => (bool)$post->consent->consentThirdPartyPhone,
                    "remarketing_sms" => (bool)$post->consent->consentThirdPartySMS,
                ),
            ),
        );

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
        require_once dirname(__DIR__) . '/vendor/BizFella/Application.php';
        require_once dirname(__DIR__) . '/vendor/BizFella/Params.php';
        require_once dirname(__DIR__) . '/vendor/BizFella/Applicant.php';
        require_once dirname(__DIR__) . '/vendor/BizFella/Employment.php';
        require_once dirname(__DIR__) . '/vendor/BizFella/Consent.php';
        require_once dirname(__DIR__) . '/vendor/BizFella/Residence.php';
        require_once dirname(__DIR__) . '/vendor/BizFella/Loan.php';
        require_once dirname(__DIR__) . '/vendor/BizFella/Bank.php';
        require_once dirname(__DIR__) . '/vendor/BizFella/Status.php';
        require_once dirname(__DIR__) . '/vendor/BizFella/TestMode.php';
        require_once dirname(__DIR__) . '/vendor/autoload.php';
        require_once dirname(__DIR__) . '/vendor/BizFella/ExtendedValidator.php';
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
