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


class tdotuk
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
            "AffiliateApiKey" => "00000000-0000-0000-0000-000000000001",
            "AffiliateReference" => "2605",
            "AffiliateSubReference" => "Big Loans",
            "AffiliateCampaign" => "WEB",

            "ReferringUrl" => (string) $post->source->referringUrl,
            "CreationUrl" => (string) $post->source->creationUrl,
            "UserAgent" => (string) $post->source->userAgent,
            "IpAddress" => (string) $post->source->ipAddress,

            "Salutation" => (string)$post->applicant->firstName,
            "FirstName" => (string)$post->applicant->firstName,
            "LastName" => (string)$post->applicant->firstName,
            "DateOfBirthDay" => (string)$post->applicant->dateOfBirthDay,
            "DateOfBirthMonth" => (string)$post->applicant->dateOfBirthMonth,
            "DateOfBirthYear" => (string)$post->applicant->dateOfBirthYear,
            "MaritalStatus" => (string)$post->applicant->maritalStatus,

            "ConsentToCreditSearch" => (bool)$post->consent->consentCreditSearch,
            "ConsentToMarketingEmails" => (bool)$post->consent->consentToMarketingEmails,
            "ConsentToMarketingSMS" =>  (bool)$post->consent->consentToMarketingSMS,
            "MarketingPreferenceConsent" =>  (bool)$post->consent->consentCreditSearch,
            "ConsentToTerms" => (bool)$post->consent->consentFinancial,

            "ResidentialCostPerMonth" => (string)$post->residence->monthlyMortgageRent,
            "ResidentialStatus" => (string)$post->residence->residentialStatus,
            "NumberOfDependants" => (string)$post->applicant->numberOfDependants,

            "BankAccountNumber" => (int) $post->bank->bankAccountNumber,
            "BankSortCode" => (int) $post->bank->bankRountingNumber,
            "BankCardType" => (int) $post->bank->bankCardType,

            "HouseNumber" => (string)$post->residence->houseNumber,
            "Street1" => (string)$post->residence->addressStreet1,
            "TownCity" => (string)$post->residence->city,
            "CountyState" => (string)$post->residence->county,
            "PostCode" => (string)$post->residence->postcode,
            "CountryCode" => "GB",
            "MonthsAtAddress" => (string)$post->residence->monthsAtAddress,

            "MobilePhoneNumber" => (string)$post->applicant->mobilePhoneNumber,
            "HomePhoneNumber" => (string)$post->applicant->homePhoneNumber,
            "WorkPhoneNumber" => (string)$post->applicant->workPhoneNumber,
            "EmailAddress" => (string)$post->applicant->email,

            "LoanAmount" => (int) $post->loan->loanAmount,
            "LoanPurposeType" => (int) $post->loan->loanPurpose,
            "LoanTerm" => (int) $post->loan->loanTerm,
            "LoanTermType" => "Months", // Days | Months | Years

            "EmploymentStatus" =>  (int) $post->employer->incomeSource,
            "Occupation" =>  (int) $post->employer->jobTitle,
            "EmployerPosition" =>  (int) $post->employer->employerIndustry,
            "EmployerName" =>  (int) $post->employer->employerName,

            "MonthsWithEmployer" =>  (int) $post->employer->monthsAtEmployer,
            "EmployerIndustry" =>  (int) $post->employer->employerIndustry,
            "Income" =>  (int) $post->employer->monthlyIncome,
            "IncomeFrequency" =>  (int) $post->employer->incomeCycle,
            "IncomePaymentType" =>  (int) $post->employer->incomePaymentType,

            "NextPayDateDay" => (int)$post->employer->nextPayDateYear,
            "NextPayDateMonth" =>(int)$post->employer->nextPayDateMonth,
            "NextPayDateYear" =>(int)$post->employer->nextPayDateYear,
            "FollowingPayDateDay" => (int)$post->employer->followingPayDateDay,
            "FollowingPayDateMonth" => (int)$post->employer->followingPayDateMonth,
            "FollowingPayDateYear" => (int)$post->employer->followingPayDateYear,

            "MonthlyCreditCommitments" =>  (int) $post->expense->monthlyMortgageRent,
            "MonthlyUtilityExpenses" =>  (int) $post->expense->utilitiesExpense,
            "MonthlyTransportExpenses" =>  (int) $post->expense->transportExpense,
            "MonthlyFoodExpenses" =>  (int) $post->expense->foodExpense,
            "OtherMonthlyOutgoings" =>  (int) $post->expense->otherExpense,
            "CombinedHouseholdIncome" => (float) $post->applicant->combinedMonthlyHouseholdIncome,

            "ExpenditureConfirmed" => true,
            "AdultsAtAddress" =>(int) $post->residence->numberOfAdults,
            "MonthlyBenefits" => (int) $post->residence->governmentBenefitsAmount,
            "MonthlyPension" => (int) $post->residence->pensionAmount,
            "LoansInLastThreeMonths" => (int) $post->loan->recentLoanAmount,

            "CouncilTax" => (int) $post->expense->councilTaxExpense ?? 0,
            "HouseholdGoods" => (int) $post->expense->householdGoodsExpense ?? 0,
            "ClothingAndFootwear" => (int) $post->expense->clothingFootwearExpense ?? 0,
            "Education" => (int) $post->expense->educationExpense ?? 0,
            "AlcoholicDrinksAndTobacco" => (int) $post->expense->alcoholTobaccoExpense ?? 0,
            "HealthAndBeauty" => (int) $post->expense->healthBeautyExpense ?? 0,
            "Restaurants" => (int) $post->expense->restaurantsExpense ?? 0,
            "Recreation" => (int) $post->expense->recreationExpense ?? 0,
            "CommsAndEntertainment" => (int) $post->expense->communicationEntertainmentExpense ?? 0,

            "IsTestLead" => "true",
            "TestResponseType" => "AcceptedByLender",
            "TypeOfHousing" => (int) $post->residence->typeOfHousing,
            "RentSplitWith" => (int) $post->residence->numberOfRenters,
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
