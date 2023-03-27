<?php

class mmpfinancial
{

    // TEST
    // http://testleadsuk.blizzardi.com/whiteboxeyesptp/validate.asmx?WSDL
    // LIVE
    //http://leadsuk.blizzardi.com/whiteboxeyesPTP/validate.asmx?WSDL


    function __construct($client_detail, $post)
    {
        $this->manageDependencies();
        unset($root, $library, $path);

        try {
            $today = new DateTime("now", new DateTimeZone("UTC"));
        } catch (Exception $e) {
        }


        $dob_day = $post->applicant->dateOfBirthDay;
        $dob_month = $post->applicant->dateOfBirthMonth;
        $dob_year = $post->applicant->dateOfBirthYear;

        // nextPayDateDay
        $next_pay_date_day = $post->employer->nextPayDateDay;
        $next_pay_date_month = $post->employer->nextPayDateMonth;
        $next_pay_date_year = $post->employer->nextPayDateYear;

        // followingPayDateDay
        $followingPayDateDay = $post->employer->followingPayDateDay;
        $followingPayDateMonth = $post->employer->followingPayDateMonth;
        $followingPayDateYear = $post->employer->followingPayDateYear;

        // monthsAtAddress
        $numberOfMonthsAtAddress = floor($post->applicant->monthsAtAddress);
        $date = date("c", strtotime('-' . $numberOfMonthsAtAddress . " months", strtotime($post->created_at)));
        $AddressMoveIn = date("c", strtotime($date));

        // monthsAtEmployer
        $numberOfMonthsInCurrentEmploymentStatus = floor($post->employer->monthsAtEmployer);
        $date = date("c", strtotime('-' . $numberOfMonthsInCurrentEmploymentStatus . " months", strtotime($post->created_at)));
        $EmploymentStarted = date("c", strtotime($date));

        // bankAccountLength
        $numberOfMonthsInBank = floor($post->bank->bankAccountLength);
        $date = date("c", strtotime('-' . $numberOfMonthsInBank . " months", strtotime($post->created_at)));
        $BankAccountOpened = date("c", strtotime($date));

        $monthsAtEmployer = '123';


        switch ($post->residence->residentialStatus) {
            case 'HomeOwner':
                $post->residence->residentialStatus = 1;
            case 'PrivateTenant':
                $post->residence->residentialStatus = 2;
            case 'CouncilTenant':
                $post->residence->residentialStatus = 3;
            case 'LivingWithParents':
                $post->residence->residentialStatus = 4;
            case 'LivingWithFriends':
                $post->residence->residentialStatus = 4;
            case 'Other':
                $post->residence->residentialStatus = 5;

        }
        switch ($post->employment->employerIndustry) {
            case 'ConstructionManufacturing':
                $post->employment->employerIndustry = 1;
            case 'Military':
                $post->employment->employerIndustry = 2;
            case 'Health':
                $post->employment->employerIndustry = 3;
            case 'BankingInsurance':
                $post->employment->employerIndustry = 4;
            case 'Education':
                $post->employment->employerIndustry = 5;
            case 'CivilService':
                $post->employment->employerIndustry = 6;
            case 'SupermarketRetail':
                $post->employment->employerIndustry = 7;
            case 'UtilitiesTelecom':
                $post->employment->employerIndustry = 8;
            case 'HotelRestaurantAndLeisure':
                $post->employment->employerIndustry = 9;
            case 'OtherOfficeBased':
                $post->employment->employerIndustry = 10;
            case 'OtherNotOfficeBased':
                $post->employment->employerIndustry = 11;
            case 'DrivingDelivery':
                $post->employment->employerIndustry = 11;
            case 'AdministrationSecretarial':
                $post->employment->employerIndustry = 10;
            case 'MidLevelManagement':
                $post->employment->employerIndustry = 10;
            case 'SeniorLevelManagement':
                $post->employment->employerIndustry = 10;
            case 'SkilledTrade':
                $post->employment->employerIndustry = 10;
            case 'Professional':
                $post->employment->employerIndustry = 11;


        }



        $HomeownerStatus = '';
        $EmployerIndustry = '';

        // POST DATA
        $json = array(
            "AcceptRedirect" => (string)'123',
            "RejectRedirect" => (string)'123',
            "BusyWait" => (string)'123',

            "Vendor" => (string)'MMP-VENDOR-ID',
            "vendorSubID" => (string)$post->aff_sub ?? 'UPING',

            "firstName" => (string)$post->applicant->firstName,
            "lastName" => (string)$post->applicant->lastName,
            "dobDay" => (int)$dob_day,
            "dobMonth" => (int)$dob_month,
            "dobYear" => (int)$dob_year,
            "gender" => (string)$post->applicant->gender ?? 'unspecified',

            "streetNumber" => (string)$post->residence->houseNumber ?? (string)$post->residence->houseName,
            "streetName" => (string)$post->residence->addressStreet1,
            "city" => (string)$post->residence->city,
            "county" => (string)$post->residence->county,
            "zipCode" => (string)$post->residence->postcode,

            "occupancy" => (string)$post->employer->employerIndustry ?? 'unknown',
            "monthsAtResidence" => (string)$AddressMoveIn ?? '10-11-2018',

            "homeArea" => '+44',
            "homeExch" => '123',
            "homeNumb" => (string)$post->applicant->homePhoneNumber,
            "cellArea" => '+44',
            "cellExch" => '123',
            "cellNumb" => (string)$post->applicant->mobilePhoneNumber,
            "workArea" => '+44',
            "workExch" => '123',
            "workNumb" => (string)$post->applicant->workPhoneNumber,

            "emailAdd" => (string)$post->applicant->email,
            "employer" => (string)$post->employer->employerName ?? 'NOT AVAILABLE',
            "employerPosition" => (string)$post->employer->jobTitle,

            "ipAddress" => (string)$post->source->ipAddress,
            "referrerURL" => (string)$post->source->referringUrl,
            "directDebit" => (int)$post->employer->incomePaymentType,

            "incomeSource" => (int)$post->employer->incomeSource,
            "payFrequency" => (int)$post->employer->incomeCycle,

            "netIncome" => (int)$post->expense->monthlyMortgageRent,
            "BankAccount" => (string)$post->bank->bankAccountNumber,
            "AccountType" => '123',
            "SortCode" => (string)$post->bank->bankRoutingNumber,
            "DebitCard" => (int)$post->bank->bankCardType,
            "NextPayDay" => (int)$next_pay_date_day,
            "NextPayMonth" => (int)$next_pay_date_month,
            "NextPayYear" => (int)$next_pay_date_year,
            "FollowingPayDay" => (int)$followingPayDateDay,
            "FollowingPayMonth" => (int)$followingPayDateMonth,
            "FollowingPayYear" => (int)$followingPayDateYear,
            "MonthsAtEmployer" => (int)$monthsAtEmployer,
            "DayOfWeekPay" => '123',
            "DayOfMonthPay" => '123',
            "HomeownerStatus" => (int)$HomeownerStatus,
            "EmployerIndustry" => (string)$EmployerIndustry,
            "PingSequence" => '123',
            "UserAgent" => (string)$post->source->userAgent,
            "Title" => (int)$post->applicant->nameTitle,
            "TimeAtBank" => $BankAccountOpened,
            "MaritalStatus" => (int)$post->applicant->maritalStatus,

            "MonthlyMortgageRent" => (int)$post->expense->monthlyMortgageRent,
            "MonthlyCreditCommitments" => (int)$post->expense->creditExpense,
            "OtherExpenses" => (int)$post->expense->otherExpense,
        );

        Log::debug('POST DATA::', (array)$json);
        Log::debug('HTTP POST DATA::', (array)http_build_query($json));

        $this->response['post_data'] = $json;
//        $this->response['header'] = array(
//            'Accept: application/json, text/javascript, *.*',
//            'Content-type: application/json; charset=utf-8'
//        );
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

    public function returnresponse()
    {
        $appResponse = $this->response['application_response'];
        Log::debug('APP RESP::', (array)$appResponse['res']);

        $resp_data = json_decode($appResponse['res']);
        Log::debug('DEBUG::', (array)$resp_data);


        $this->response['post_res'] = json_encode($resp_data);
        Log::debug('RESP2 :: ', (array)$this->response);

        $resp = $this->response['post_res'];


        if ($resp == '') {
            $this->response['accept'] = 'Validation Failed';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
            $this->response['post_time'] = $appResponse['post_time'];
            return $this->response;
        }
        // RESPONSE ?? TEST
        if ($resp == 'accept') {
            $this->response['accept'] = 'ACCEPTED';
            $this->response['post_price'] = $resp->estimatedcommission->Amount;
            $this->response['post_status'] = '1';
            $this->response['redirect_url'] = $resp->redirecturl;
            $this->response['post_time'] = $resp['post_time'];
        } else {
            $this->response['accept'] = 'REJECTED';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
            $this->response['post_time'] = $resp['post_time'];
            $this->response['reason'] = $resp['reason'];
        }
        //print_r($this->response);exit;
        return $this->response;
    }

    private function manageDependencies()
    {
        require_once dirname(__DIR__) . '/vendor/PingYo/Application.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/SourceDetails.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/ApplicationDetails.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/Status.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/TitleType.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/BankCardType.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/ResidentialStatusType.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/IncomePaymentType.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/PayFrequencyType.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/IncomeSourceType.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/EmployerIndustryType.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/NationalIdentityNumberType.php';
        require_once dirname(__DIR__) . '/vendor/autoload.php';
        require_once dirname(__DIR__) . '/vendor/PingYo/ExtendedValidator.php';

    }

}
