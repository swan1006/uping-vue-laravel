<?php

//sleep(10);
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class pingyo
{

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
        if (strlen($dob_day) < 2) {
            $dob_day = '0' . $dob_day;
        }
        if (strlen($dob_month) < 2) {
            $dob_month = '0' . $dob_month;
        }

        if ($dob_month > '12') {
            try {
                $dob = new DateTime($dob_year . '/' . $dob_day . '/' . $dob_month, new DateTimeZone("UTC"));
                $dateOfBirth = '/Date(' . ($dob->getTimestamp() * 1000) . ')/';
                Log::debug('DOB Month > 12::', (array)$dateOfBirth);
            } catch (Exception $e) {
                $dob = strtotime($dob_year . '/' . $dob_day . '/' . $dob_month);
                $dateOfBirth = '/Date(' . $dob . ')/';
                Log::debug('DOB CATCH::', (array)$dateOfBirth);

                if ($dob === '') {
                    $dob = date("U", strtotime($dob_year . '/' . $dob_day . '/' . $dob_month));
                    $dateOfBirth = '/Date(' . $dob . ')/';
                    Log::debug('DOB EMPTY::', (array)$dateOfBirth);
                }
            }
        } else {
            try {
                $dob = new DateTime($dob_year . '/' . $dob_month . '/' . $dob_day, new DateTimeZone("UTC"));
                $dateOfBirth = '/Date(' . ($dob->getTimestamp() * 1000) . ')/';
                Log::debug('DOB TRY::', (array)$dateOfBirth);
            } catch (Exception $e) {
                $dob = strtotime($dob_year . '/' . $dob_month . '/' . $dob_day);
                $dateOfBirth = '/Date(' . $dob . ')/';
                Log::debug('DOB CATCH::', (array)$dateOfBirth);

                if ($dob === '') {
                    $dob = date("U", strtotime($dob_year . '/' . $dob_month . '/' . $dob_day));
                    $dateOfBirth = '/Date(' . $dob . ')/';
                    Log::debug('DOB EMPTY::', (array)$dateOfBirth);
                }
            }
        }

        Log::debug('DOB::', (array) $dateOfBirth);


        // nextPayDateDay
        $next_pay_date_day = $post->employer->nextPayDateDay;
        $next_pay_date_month = $post->employer->nextPayDateMonth;
        $next_pay_date_year = $post->employer->nextPayDateYear;
        $npd = new DateTime($next_pay_date_year . '/' . $next_pay_date_month . '/' . $next_pay_date_day, new DateTimeZone("UTC"));
        $nextPayDate = '/Date(' . ($npd->getTimestamp() * 1000) . ')/';

        // followingPayDateDay
        $followingPayDateDay = $post->employer->followingPayDateDay;
        $followingPayDateMonth = $post->employer->followingPayDateMonth;
        $followingPayDateYear = $post->employer->followingPayDateYear;
        $fpd = new DateTime($followingPayDateYear . '/' . $followingPayDateMonth . '/' . $followingPayDateDay, new DateTimeZone("UTC"));
        $followingPayDate = '/Date(' . ($fpd->getTimestamp() * 1000) . ')/';

        // monthsAtAddress
        $numberOfMonthsAtAddress = floor($post->applicant->monthsAtAddress);
        $date = date("c", strtotime('-' . $numberOfMonthsAtAddress . " months", strtotime($post->created_at)));
        $AddressMoveIn = date("c", strtotime($date));
        $ami = new DateTime($AddressMoveIn, new DateTimeZone("UTC"));
        $AddressMoveIn = '/Date(' . ($ami->getTimestamp() * 1000) . ')/';

        // monthsAtEmployer
        $numberOfMonthsInCurrentEmploymentStatus = floor($post->employer->monthsAtEmployer);
        $date = date("c", strtotime('-' . $numberOfMonthsInCurrentEmploymentStatus . " months", strtotime($post->created_at)));
        $EmploymentStarted = date("c", strtotime($date));
        $es = new DateTime($EmploymentStarted, new DateTimeZone("UTC"));
        $EmploymentStarted = '/Date(' . ($es->getTimestamp() * 1000) . ')/';

        // bankAccountLength
        $numberOfMonthsInBank = floor($post->bank->bankAccountLength);
        $date = date("c", strtotime('-' . $numberOfMonthsInBank . " months", strtotime($post->created_at)));
        $BankAccountOpened = date("c", strtotime($date));
        $bao = new DateTime($BankAccountOpened, new DateTimeZone("UTC"));
        $BankAccountOpened = '/Date(' . ($bao->getTimestamp() * 1000) . ')/';

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
                $post->employer->incomeSource = 1;
            case 'EmployedFullTime':
                $post->employer->incomeSource = 2;
            case 'EmployedPartTime':
                $post->employer->incomeSource = 3;
            case 'EmployedTemporary':
                $post->employer->incomeSource = 4;
            case 'Pension':
                $post->employer->incomeSource = 5;
            case 'DisabilityBenefits':
                $post->employer->incomeSource = 6;
            case 'Benefits':
                $post->employer->incomeSource = 7;
        }
        switch ($post->employer->EmployerIndustry) {
            case 'ConstructionManufacturing':
                $post->employer->incomeSource = 1;
            case 'Military':
                $post->employer->incomeSource = 2;
            case 'Health':
                $post->employer->incomeSource = 3;
            case 'BankingInsurance':
                $post->employer->incomeSource = 4;
            case 'Education':
                $post->employer->incomeSource = 5;
            case 'CivilService':
                $post->employer->incomeSource = 6;
            case 'SupermarketRetail':
                $post->employer->incomeSource = 7;
            case 'UtilitiesTelecom':
                $post->employer->incomeSource = 8;
            case 'HotelRestaurantAndLeisure':
                $post->employer->incomeSource = 9;
            case 'OtherOfficeBased':
                $post->employer->incomeSource = 10;
            case 'OtherNotOfficeBased':
                $post->employer->incomeSource = 11;
            case 'None':
                $post->employer->incomeSource = 12;
            case 'DrivingDelivery':
                $post->employer->incomeSource = 13;
            case 'AdministrationSecretarial':
                $post->employer->incomeSource = 14;
            case 'MidLevelManagement':
                $post->employer->incomeSource = 15;
            case 'SeniorLevelManagement':
                $post->employer->incomeSource = 16;
            case 'SkilledTrade':
                $post->employer->incomeSource = 17;
            case 'Professional':
                $post->employer->incomeSource = 18;
        }
        switch ($post->loan->loanPurpose) {
            case 'Subsistence':
                $post->employer->incomeSource = 1;
            case 'OneOffPurchase':
                $post->employer->incomeSource = 2;
            case 'Other':
                $post->employer->incomeSource = 3;
            case 'EmployedTemporary':
                $post->employer->incomeSource = 4;
            case 'CarLoan':
                $post->employer->incomeSource = 5;
            case 'PayBills':
                $post->employer->incomeSource = 6;
            case 'PayOffLoan':
                $post->employer->incomeSource = 7;
            case 'ShortTermCash':
                $post->employer->incomeSource = 8;
            case 'HomeImprovements':
                $post->employer->incomeSource = 9;
            case 'Holiday':
                $post->employer->incomeSource = 10;
            case 'HouseholdPersonalGoods':
                $post->employer->incomeSource = 11;
            case 'Presents':
                $post->employer->incomeSource = 12;
            case 'HouseholdBills':
                $post->employer->incomeSource = 13;
            case 'CelebrationMajorEvent':
                $post->employer->incomeSource = 14;
            case 'EducationTraining':
                $post->employer->incomeSource = 15;
            case 'RelocationMoving':
                $post->employer->incomeSource = 16;
            case 'Pets':
                $post->employer->incomeSource = 17;
            case 'Entertainment':
                $post->employer->incomeSource = 18;
            case 'Gambling':
                $post->employer->incomeSource = 19;

        }
        switch ($post->employer->incomeCycle) {
            case 'Weekly':
                $post->employer->incomeCycle = 1;
            case 'BiWeekly':
                $post->employer->incomeCycle = 2;
            case 'TwiceMonthly':
                $post->employer->incomeCycle = 7;
            case 'Fortnightly':
                $post->employer->incomeCycle = 7;
            case 'FourWeekly':
                $post->employer->incomeCycle = 8;
            case 'Monthly':
                $post->employer->incomeCycle = 8;
            case 'LastWorkingDayMonth':
                $post->employer->incomeCycle = 14;
            case 'LastDayMonth':
                $post->employer->incomeCycle = 14;
        }
        switch ($post->employer->incomePaymentType) {
            case 'Cash':
                $post->employer->incomePaymentType = 2;
            case 'Cheque':
                $post->employer->incomePaymentType = 3;
            case 'RegionalDirectDeposit':
                $post->employer->incomePaymentType = 4;
            case 'NonRegionalDirectDeposit':
                $post->employer->incomePaymentType = 2;
        }
        switch ($post->applicant->inMilitary) {
            case 'None':
                $post->applicant->inMilitary = 1;
            case 'Veteran':
                $post->applicant->inMilitary = 2;
            case 'Reserves':
                $post->applicant->inMilitary = 3;
            case 'ActiveDuty':
                $post->applicant->inMilitary = 4;
        }
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
                $post->residence->residentialStatus = 5;
            case 'Other':
                $post->residence->residentialStatus = 6;

        }
        switch ($post->bank->bankAccountType) {
            case 'Checking':
                $post->bank->bankAccountType = 1;
            case 'Savings':
                $post->bank->bankAccountType = 2;

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
        if ($post->consent->consentFinancial ===  1) {
            $post->consent->consentFinancial = true;
        } else {
            $post->consent->consentFinancial = false;
        }
        if ($post->consent->consentCreditSearch === 1) {
            $post->consent->consentCreditSearch = true;
        } else {
            $post->consent->consentCreditSearch = false;
        }
        if ($post->consent->consentThirdPartyEmails === 1) {
            $post->consent->consentThirdPartyEmails = true;
        } else {
            $post->consent->consentThirdPartyEmails = false;
        }
        if ($post->consent->consentThirdPartySMS === 1) {
            $post->consent->consentThirdPartySMS = true;
        } else {
            $post->consent->consentThirdPartySMS = false;
        }
        if ($post->consent->consentThirdPartyPhone === 1) {
            $post->consent->consentThirdPartySMS = true;
        } else {
            $post->consent->consentThirdPartyPhone = false;
        }

        if ($post->employer->jobTitle === '') {
            $post->employer->jobTitle = 'unknown';
        }


        // POST DATA
        $json = array(
            "AffiliateId" => (string) "TOMJ",
            "Campaign" => (string) $post->partner_id ?? 'UPING',
            "SubAffiliate" => (string) $post->aff_sub ?? '',
            "Timeout" => (int) $client_detail->timeout ?? '120',
            "TestOnly" => (boolean) true,

            "SourceDetails" => array(
                "Address" => (string) $post->source->ipAddress,
                "ClientUserAgent" => (string) $post->source->userAgent,
                "CreationUrl" => (string) $post->source->creationUrl,
                "ReferringUrl" => (string) $post->source->referringUrl,
            ),
            "Application" => array(
                "ConsentToCreditSearch" =>  (boolean)true,
                "Title" => (int) $post->applicant->nameTitle ?? 1,
                "FirstName" => (string) $post->applicant->firstName,
                "LastName" => (string) $post->applicant->lastName,
                "DateOfBirth" => (string) $dateOfBirth,
                "Email" => (string) $post->applicant->email,
                "HomePhoneNumber" => (string) $post->applicant->homePhoneNumber,
                "MobilePhoneNumber" => (string) $post->applicant->mobilePhoneNumber,
                "WorkPhoneNumber" => (string) $post->applicant->workPhoneNumber ?? $post->applicant->mobilePhoneNumber,

                "EmployerName" =>  (string) $post->employer->employerName ?? 'NOT AVAILABLE',
                "JobTitle" => (string) $post->employer->jobTitle ?? 'unknown',
                "EmploymentStarted" => (string) $EmploymentStarted,
                "EmployerIndustry" => (string) $post->employer->employerIndustry,
                "IncomeSource" => (int) $post->employer->incomeSource,
                "PayFrequency" =>  (int) $post->employer->incomeCycle,
                "PayAmount" => (int) $post->employer->monthlyIncome,
                "IncomePaymentType" => (int) $post->employer->incomePaymentType,
                "GovernmentBenefitsAmount" => (int) $post->employer->governmentBenefitsAmount,
                "PensionAmount" => (int) $post->employer->pensionAmount,
                "OtherIncomeAmount" => (int) $post->employer->otherIncomeAmount,

                "NextPayDate" => (string) $nextPayDate,
                "FollowingPayDate" => (string) $followingPayDate,

                "LoanAmount" => (int) $post->loan->loanAmount,
                "RecentLoanAmount" => (int) $post->loan->recentLoanAmount,
                "Term" => (int) $post->loan->loanTerms,
                "LoanProceedUse" => (int) $post->loan->loanPurpose,

                "ResidentialStatus" => (int) $post->residence->residentialStatus,
                "HouseNumber" => (string) $post->residence->houseNumber,
                "HouseName" =>  (string) $post->residence->houseName,
                "AddressStreet1" => (string) $post->residence->addressStreet1,
                "AddressCity" => (string) $post->residence->city,
                "AddressCounty" => (string) $post->residence->county,
                "AddressMoveIn" => (string) $AddressMoveIn ?? '10-11-2018',
                "AddressPostcode" =>  (string) $post->residence->postcode,

                "UsesOnlineBanking" =>  (string) $post->bank->onlineBanking,
                "BankAccountNumber" => (string) $post->bank->bankAccountNumber,
                "BankRoutingNumber" => (string) $post->bank->bankRoutingNumber,
                "BankCardType" => (int) $post->bank->bankCardType,

                "MonthlyMortgageRent" => (int) $post->expense->monthlyMortgageRent,
                "MonthlyCreditCommitments" => (int) $post->expense->creditExpense,
                "OtherExpenses" => (int) $post->expense->otherExpense,
                "Transport" => (int) $post->expense->transportExpense,
                "Food" => (int) $post->expense->foodExpense,
                "Utilities" => (int) $post->expense->utilitiesExpense,


                "TypeOfHousing" => (int) $post->residence->typeOfHousing,
                "NumberOfRenters" => (int) $post->residence->numberOfRenters,
                "NumberOfAdults" => (int) $post->residence->numberOfAdults,
                "MaritalStatus" =>  (int) $post->applicant->maritalStatus ?? 1,
                "NumberOfDependents" => (int) $post->applicant->dependants,
                "CombinedMonthlyHouseholdIncome" => (float) $post->applicant->combinedMonthlyHouseholdIncome,

//                "NationalIdentityNumber" => (string) $post->applicant->ssn,

                "ConsentToMarketingEmails" => (boolean) $post->consent->consentThirdPartyEmails,
                "ConsentToMarketingSms" => (boolean) $post->consent->consentToMarketingSMS,
                "ConsentToMarketingPhone" => (boolean) $post->consent->consentToMarketingPhone,
//                "MinimumCommissionAmount" => (float) $client_detail->min_price,
//                "MaximumCommissionAmount" => (float) $client_detail->max_price,
            )
        );

        Log::debug('POST DATA::', (array)$json);

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

    public function returnresponse()
    {
        $appResponse = $this->response['application_response'];
        Log::debug('APP RESP::', (array)$appResponse['res']);

        $resp_data = json_decode($appResponse['res']);
        Log::debug('DEBUG::', (array)$resp_data);

        Log::debug('APP RESP::', (array)$resp_data->CorrelationId);
        $CorrelationId = $resp_data->CorrelationId;
        $appResponse['correlationid'] = $CorrelationId;


        $this->response['validated'] = true;
        if ($this->response['validated'] === true) {
            $status = new PingYo\Status('202', null, $appResponse['correlationid'], null);
            Log::debug('RESP STATUS::', (array)$status);

            $counter = 0;
            while (true) {
                $res = $status->refresh();
                Log::debug('STATUS REFRESH::', (array)$res);
                $counter++;
                if ($status->percentagecomplete == 100) {
                    break;
                }

                sleep(3);
            }

            $this->response['post_res'] = json_encode($res);
            $this->response['correlationid'] = $status->correlationid;
            Log::debug('RESP2 :: ', (array)$this->response);
            Log::debug('RESP3 :: ', (array)$status);
            //print_r($price); print_r($status);exit;

            if ($status->status == 'LenderMatchFound') {
                $this->response['accept'] = 'ACCEPTED';
                $this->response['post_price'] = $status->estimatedcommission->Amount;
                $this->response['post_status'] = '1';
                try {
                    $this->response['redirect_url'] = $status->redirecturl;
                } catch (Exception $e) {
                    $this->response['redirect_url'] = $status->redirectionurl;
                }
                $this->response['post_time'] = $appResponse['post_time'];
            } else {
                $this->response['accept'] = 'REJECTED';
                $this->response['post_status'] = '0';
                $this->response['post_price'] = '0';
                $this->response['post_time'] = $appResponse['post_time'];
            }
            //print_r($this->response);exit;
            return $this->response;
        } else {
            $this->response['accept'] = 'Validation Failed';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
            $this->response['post_time'] = $appResponse['post_time'];
            return $this->response;
        }

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

    function get_client_ip()
    {
        $ipaddress = '';
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

}
