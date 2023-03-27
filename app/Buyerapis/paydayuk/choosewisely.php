<?php

class choosewisely
{

    function __construct($client_detail, $post)
    {
        $this->manageDependencies();
        unset($root, $library, $path);

        try {
            $today = new DateTime("now", new DateTimeZone("UTC"));
        } catch (Exception $e) {
        }


        //https://stage-lps.api-hub.co.uk/api/ProcessApp

        $dob_day = $post->applicant->dateOfBirthDay;
        $dob_month = $post->applicant->dateOfBirthMonth;
        $dob_year = $post->applicant->dateOfBirthYear;
        $dateOfBirth = $dob_day . '/' . $dob_month . '/' . $dob_year;


        // nextPayDateDay
        $next_pay_date_day = $post->employer->nextPayDateDay;
        $next_pay_date_month = $post->employer->nextPayDateMonth;
        $next_pay_date_year = $post->employer->nextPayDateYear;
        $nextPayDate = '1234';

        // followingPayDateDay
        $followingPayDateDay = $post->employer->followingPayDateDay;
        $followingPayDateMonth = $post->employer->followingPayDateMonth;
        $followingPayDateYear = $post->employer->followingPayDateYear;
        $followingPayDate = '1234';


        // monthsAtAddress
        $numberOfMonthsAtAddress = floor($post->applicant->monthsAtAddress);
        $date = date("c", strtotime('-' . $numberOfMonthsAtAddress . " months", strtotime($post->created_at)));
        $AddressMoveIn = date("c", strtotime($date));

        // monthsAtEmployer
        $numberOfMonthsInCurrentEmploymentStatus = floor($post->employer->monthsAtEmployer);
        $date = date("c", strtotime('-' . $numberOfMonthsInCurrentEmploymentStatus . " months", strtotime($post->created_at)));
        $EmploymentStarted = date("c", strtotime($date));
        $timeWithEmployer = $EmploymentStarted;

        // bankAccountLength
        $numberOfMonthsInBank = floor($post->bank->bankAccountLength);
        $date = date("c", strtotime('-' . $numberOfMonthsInBank . " months", strtotime($post->created_at)));
        $BankAccountOpened = date("c", strtotime($date));

        $created_at = '';
//        $BankAccountOpened;
        $consentThirdParty = '';
        $consentThirdPartyMarketing = '';
        $employmentStatus = '';

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


        if ($post->employer->jobTitle === '') {
            $post->employer->jobTitle = 'unknown';
        }


        // POST DATA
        $json = array(
            "LenderPanelReference" => "123",
            "IntroducerDetails" => array(
                "LeadReference" => (string)'123',
                "Source" => (string) $post->aff_sub ?? '',
                "SubSource" => (string) $post->aff_sub ?? '',
                "CampaignID" => (string) $post->aff_sub ?? '',
                "SubmittedBy" => (string) '123',
                "SubCampaign" => (string) $post->aff_sub ?? '',
                "IntroducerID" => (string) $post->aff_sub ?? '',
                "TierKey" => (string) $post->aff_sub ?? '',
            ),
            "OptInDetails" => array(
                "UserAgent" => (string) $post->source->userAgent,
                "IP" => (string) $post->source->ipAddress,
                "URL" => (string) $post->source->referringUrl,
                "OptInDateTime" => (string) $created_at,
            ),
            "Application" => array(
                "ConsentToProceed" => (boolean) $post->consent->consentFinancial,
                "CreditSearchConsent" => (boolean) $post->consent->consentFinancial ?? true,
                "ThirdPartyConsent" => (boolean) $consentThirdParty ?? '',
                "MarketingConsent" => (boolean) $consentThirdPartyMarketing ?? '',

                "LoanAmount" => (int) $post->loan->loanAmount,
                "LoanTerm" =>(int) $post->loan->loanTerms,
                "LoanPurposeID" => (string) $post->loan->loanPurpose,
                "MaritalStatusID" =>(string) $post->applicant->maritalStatus,
                "ResidentialStatusID" => (string) $post->residence->residentialStatus,

                "TitleID" => (string) $post->applicant->nameTitle,
                "Forename" => (string) $post->applicant->firstName,
                "Surname" => (string) $post->applicant->lastName,
                "DoB" => (string) $dateOfBirth,

                "ContactInfo" => array(
                    "HomeTel" => (string) $post->applicant->homePhoneNumber,
                    "Mobile" => (string) $post->applicant->mobilePhoneNumber,
                    "Email" => (string) $post->applicant->email,
                ),
                "CurrentAddress" => array(
                    "Postcode" => (string) $post->residence->postcode,
                    "HouseName" => (string) $post->residence->houseName,
                    "HouseNumber" => (string) $post->residence->houseNumber,
                    "Flat" => (string) '',
                    "Street" => (string) $post->residence->addressStreet1,
                    "TownCity" => (string) $post->residence->city,
                    "County" => (string) $post->residence->county,
                    "TimeatAddress" => (int) $AddressMoveIn ?? '0',
                ),
                "EmploymentInfo" => array(
                    "EmploymentStatusID" => (string) $employmentStatus,
                    "PayTypeID" => (string) $post->employer->incomePaymentType,
                    "PayFrequencyID" => (string) $post->employer->incomeCycle,
                    "EmploymentIndustryID" => (string) $post->employer->employerIndustry ?? '',
                    "EmploymentIndustryName" => (string) $post->employer->employerIndustry ?? 'NOT AVAILABLE',
                    "EmployerName" => (string) $post->employer->employerName ?? 'NOT AVAILABLE',
                    "Occupation" => (string) $post->employer->jobTitle ?? 'unknown',
                    "WorkTel" => (string) $post->applicant->workPhoneNumber,
                    "GrossIncome" => (int) $post->employer->monthlyIncome,
                    "NetIncome" => (int) 0,
                    "IncomeTypeID" => (string) 'Monthly',
                    "NextPayDate" => (string) $nextPayDate,
                    "FollowingPayDate" => (string) $followingPayDate,
                    "TimewithEmployer" => (int) $timeWithEmployer,
                ),
                "BankInfo" => array(

                    "BankName" => (string) "",
                    "AccountName" => (string) "",
                    "AccountNumber" => (string) $post->bank->bankAccountNumber,
                    "Sortcode" => (string) $post->bank->bankRoutingNumber,
                    "TimeAtBank" => (int) $BankAccountOpened,
                    "CardTypeID" => (string) $post->bank->bankCardType,
                    "OpenBankingProvider" => "",
                    "OpenBankingGUID" => "",
                    "OpenBankExternalRef" => "",
                    "OpenBankVerified" => (boolean) true
                ),
                "AdditionalInfo" => array(
                    "Dependents" => (int) $post->applicant->dependants,
                    "RentMortgage" => (int) $post->expense->monthlyMortgageRent,
                    "CreditExpenditure" => (int) $post->expense->creditExpense ?? 0,
                    "UtilityExpenditure" => (int) $post->expense->utilitiesExpense ?? 0,
                    "TransportExpenditure" => (int) $post->expense->transportExpense ?? 0,
                    "FoodExpenditure" => (int) $post->expense->foodExpense ?? 0,
                    "OtherExpenditure" => (int) $post->expense->otherExpense ?? 0,
                ),
            ),
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

//    public function returnresponse()
//    {
//        $appResponse = $this->response['application_response'];
//        Log::debug('APP RESP::', (array)$appResponse['res']);
//
//        $resp_data = json_decode($appResponse['res']);
//        Log::debug('DEBUG::', (array)$resp_data);
//
//        Log::debug('APP RESP::', (array)$resp_data->CorrelationId);
//        $CorrelationId = $resp_data->CorrelationId;
//        $appResponse['correlationid'] = $CorrelationId;
//
//
//        $this->response['validated'] = true;
//        if ($this->response['validated'] === true) {
//            $status = new PingYo\Status('202', null, $appResponse['correlationid'], null);
//            Log::debug('RESP STATUS::', (array)$status);
//
//            $counter = 0;
//            while (true) {
//                $res = $status->refresh();
//                Log::debug('STATUS REFRESH::', (array)$res);
//                $counter++;
//                if ($status->percentagecomplete == 100) {
//                    break;
//                }
//
//                sleep(3);
//            }
//
//            $this->response['post_res'] = json_encode($res);
//            $this->response['correlationid'] = $status->correlationid;
//            Log::debug('RESP2 :: ', (array)$this->response);
//            Log::debug('RESP3 :: ', (array)$status);
//            //print_r($price); print_r($status);exit;
//
//            if ($status->status == 'LenderMatchFound') {
//                $this->response['accept'] = 'ACCEPTED';
//                $this->response['post_price'] = $status->estimatedcommission->Amount;
//                $this->response['post_status'] = '1';
//                try {
//                    $this->response['redirect_url'] = $status->redirecturl;
//                } catch (Exception $e) {
//                    $this->response['redirect_url'] = $status->redirectionurl;
//                }
//                $this->response['post_time'] = $appResponse['post_time'];
//            } else {
//                $this->response['accept'] = 'REJECTED';
//                $this->response['post_status'] = '0';
//                $this->response['post_price'] = '0';
//                $this->response['post_time'] = $appResponse['post_time'];
//            }
//            //print_r($this->response);exit;
//            return $this->response;
//        } else {
//            $this->response['accept'] = 'Validation Failed';
//            $this->response['post_status'] = '0';
//            $this->response['post_price'] = '0';
//            $this->response['post_time'] = $appResponse['post_time'];
//            return $this->response;
//        }
//
//    }

    public function returnresponse()
    {
        $appResponse = $this->response['application_response'];
        Log::debug('APP RESP::', (array)$appResponse);

        $resp_data = json_decode((string)$appResponse['res']);
        Log::debug('DEBUG::', (array)$resp_data);

        $this->response['post_res'] = json_encode($resp_data);
        Log::debug('RESP2 :: ', (array)$this->response);


        // -1: Error (Error whilst submitting application),
        if ($resp_data->LenderResults->ApplicationStatusID === -1) {
            $this->response['accept'] = 'Validation Failed';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
            return $this->response;
        }
        // 0: UnderwriteFailed (Application not sent to lender and failed initial criteria),
        if ($resp_data->LenderResults->ApplicationStatusID === 0) {
            $this->response['accept'] = 'UnderwriteFailed';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
            return $this->response;
        }
        // 10: ProvisionalAccept (Application "Provisionally Accepted" by Lender),
        if ($resp_data->LenderResults->ApplicationStatusID === 10) {
            $this->response['accept'] = 'ACCEPTED';
            $this->response['post_price'] = $resp_data->price;
            $this->response['post_status'] = '1';
            $this->response['RedirectURL'] = $resp_data->redirect;
//                $this->response['post_time'] = $appResponse['post_time'];
        }
        // 11: NotInterested (RESERVED, indicates cases where customer turned down or not interested cases),
        elseif ($resp_data->LenderResults->ApplicationStatusID === 11) {
             $this->response['accept'] = 'ACCEPTED';
             $this->response['post_price'] = $resp_data->price;
             $this->response['post_status'] = '1';
             $this->response['RedirectURL'] = $resp_data->redirect;
//                $this->response['post_time'] = $appResponse['post_time'];
         }
        // 20: Duplicate (Duplicate Application. Could be Duplicate as identified by Lender or by Lender Panel),
        elseif ($resp_data->LenderResults->ApplicationStatusID === 20) {
             $this->response['accept'] = 'ACCEPTED';
             $this->response['post_price'] = $resp_data->price;
             $this->response['post_status'] = '1';
             $this->response['RedirectURL'] = $resp_data->redirect;
//                $this->response['post_time'] = $appResponse['post_time'];
         }
        // 30: Declined (Application is "Declined" by the Lender),
        elseif ($resp_data->LenderResults->ApplicationStatusID === 30) {
             $this->response['accept'] = 'ACCEPTED';
             $this->response['post_price'] = $resp_data->price;
             $this->response['post_status'] = '1';
             $this->response['RedirectURL'] = $resp_data->redirect;
//                $this->response['post_time'] = $appResponse['post_time'];
         }
        // 100: Completed (RESERVED, Loan Application is completed / Paid out)
        elseif ($resp_data->LenderResults->ApplicationStatusID === 100) {
             $this->response['accept'] = 'ACCEPTED';
             $this->response['post_price'] = $resp_data->Commission;
             $this->response['model_type'] = $resp_data->CommissionTypeID;
             $this->response['post_status'] = '1';
             $this->response['redirect_url'] = $resp_data->RedirectURL;
//                $this->response['post_time'] = $appResponse['post_time'];
        }

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
