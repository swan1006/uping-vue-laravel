<?php


use App\Helpers\CurlHelper;

class leadtreeglobalusa

{
    var $response = array();

    function __construct($client_detail, $post)
    {
        $monthsAtAddress = floor($post->monthsAtAddress);
        $monthsAtEmployer = floor($post->monthsAtEmployer);
        $numberOfMonthsInBank = floor($post->bankAccountLength);

        // Time at bank
        $numberOfMonthsInBank = floor($post->bank->bankAccountLength);
        $date = date("c", strtotime('-' . $numberOfMonthsInBank . " months", strtotime($post->created_at)));
        $BankAccountOpened = date("c", strtotime($date));
        $bao = new DateTime($BankAccountOpened, new DateTimeZone("UTC"));
        $BankAccountOpened = '/Date(' . ($bao->getTimestamp() * 1000) . ')/';


              $dob_day = '';
        $dob_month = '';
        $dob_year = '';


        if ($post->consentFinancial === '1' || 1) {
            $post->consentFinancial = true;
        } else {
            $post->consentFinancial = false;
        }
        if ($post->consentThirdPartyEmails === '1' || 1) {
            $post->consentThirdPartyEmails = true;
        } else {
            $post->consentThirdPartyEmails = false;
        }


        $json = array(
            "AffiliateAPIKey" => (string) "4dd3204d-a01d-452d-ae48-8d8c86343000",
            "AffiliateReference" => (string)$post->source->vid,
            "AffiliateSubReference" => (string)$post->source->aff_sub,
            "AffiliateCampaign" => (string) "UPING",
            "isTestLead" => (boolean) true,
            "TestResponseType" => (string) 'AcceptedByLender',

            "ReferringUrl" => (string) $post->source->referringUrl,
            "CreationUrl" => (string) $post->source->creationUrl,
            "UserAgent" => (string) $post->source->userAgent,
            "IpAddress" => (string) $post->source->ipAddress,

            "Salutation" => (string) $post->applicant->nameTitle,
            "FirstName" => (string) $post->applicant->firstName,
            "LastName" => (string) $post->applicant->lastName,
            "DateOfBirthDay" => (string)$post->employer->dateOfBirthDay,
            "DateOfBirthMonth" => (string)$post->employer->dateOfBirthMonth,
            "DateOfBirthYear" => (string) $post->employer->dateOfBirthYear,
            "MaritalStatus" => (string) $post->applicant->maritalStatus,
//            "IsCarOwner" => "true",
            "ConsentToCreditSearch" => (boolean) $post->consent->consentToMarketingPhone,
            "ConsentToMarketingEmails" =>(boolean) $post->consent->consentToMarketingPhone,
            "ConsentToMarketingSMS" => (boolean) $post->consent->consentToMarketingPhone,
            "MarketingPreferenceConsent" => (string) $post->consent->consentToMarketingPhone,
            "ConsentToTerms" => (boolean) $post->consent->consentToMarketingPhone,

            "ResidentialCostPerMonth" => (int) $post->residence->monthlyMortgageRent,
            "ResidentialStatus" => (string) $post->residence->residentialStatus,
            "NumberOfDependants" => (int) $post->applicant->dependants,

            "BankAccountNumber" =>  (string) $post->bank->bankAccountNumber,
            "BankSortCode" =>  (string) $post->bank->bankSortcode,
            "BankName" =>  (string) $post->bank->bankName,
            "BankCardType" =>  (string) $post->bank->bankCardType,

            "HouseNumber" => (string) $post->residence->postcode,
            "Street1" => (string) $post->residence->addressStreet1,
            "Street2" => (string) $post->residence->town,
            "TownCity" => (string) $post->residence->city,
            "CountyState" => (string) $post->residence->county,
            "PostCode" => (string) $post->residence->postcode,
            "CountryCode" => "GB",
            "MonthsAtAddress" => (string) $monthsAtAddress,

            "MobilePhoneNumber" => (string) $post->applicant->mobilePhoneNumber,
            "HomePhoneNumber" => (string) $post->applicant->homePhoneNumber,
            "WorkPhoneNumber" => (string) $post->applicant->workPhoneNumber,
            "EmailAddress" => (string) $post->applicant->email,
            "BestTimeToCall" => "Afternoon",

            "LoanAmount" => (int) $post->loan->loanAmount,
            "LoanPurposeType" => (string) $post->loan->loanPurpose,
            "LoanTerm" => (string) $post->loan->loanTerm,
            "LoanTermType" => (string) "Days",
            "EmploymentStatus" =>(string) $post->employer->incomeSource,
            "Occupation" => (string) $post->employer->incomeSource,
            "EmployerPosition" => (string) $post->employer->incomeSource,
            "EmployerName" => (string) $post->employer->incomeSource,
            "EmployerPostCode" => (string) $post->residence->postcode,
            "MonthsWithEmployer" => (string) $monthsAtEmployer,
            "EmployerIndustry" => (string) $post->employer->employerIndustry,
            "Income" => (int) $post->employer->monthlyIncome,
            "IncomeFrequency" => (string) $post->employer->incomeSource,
            "IncomePaymentType" => (string) $post->employer->onlineBanking,

            "NextPayDateDay" => (string)$post->employer->nextPayDateDay,
            "NextPayDateMonth" => (string)$post->employer->nextPayDateMonth,
            "NextPayDateYear" => (string)$post->employer->nextPayDateYear,
            "FollowingPayDateDay" => (string)$post->employer->nextPayDateDay,
            "FollowingPayDateMonth" => (string)$post->employer->nextPayDateMonth,
            "FollowingPayDateYear" => (string) $post->employer->nextPayDateYear,

            "MonthlyCreditCommitments" => (int) $post->expense->creditExpense,
            "MonthlyUtilityExpenses" => (int) $post->expense->creditExpense,
            "MonthlyTransportExpenses" => (int) $post->expense->creditExpense,
            "MonthlyFoodExpenses" => (int) $post->expense->creditExpense,
            "ExpenditureConfirmed" => "true",
            "OtherMonthlyOutgoings" => (int) $post->expense->creditExpense,
            "CombinedHouseholdIncome" => (int) $post->expense->monthlyMortgageRent,
            "AdultsAtAddress" => (int) $post->residence->numberOfAdults,
            "LoansInLastThreeMonths" => (int) $post->loan->recentLoanAmount,
            "IsTestLead" => "true",
        );


//        dd($application);

        if($client_detail->mode == 1) {
            $mode = "false";
            $TestResponseType = '';
        }else{
            $mode = "true";
            $TestResponseType = 'AcceptedByLenderWithCommission';
        }

        $this->response['post_url'] = ($client_detail->mode == '2') ? $client_detail->post_url_test : $client_detail->post_url_live;
        $this->response['post_url'] = $this->response['post_url'].$client_detail->parameter1;
        $this->response['post_data'] = json_encode($json);
        $this->response['timeout'] = $client_detail->timeout;
        $this->response['header'] = 'Content-Type: application/json';
    }

    public function returnresponse()
    {
        $result = (new App\Helpers\CurlHelper)->curl_post(
            $this->response['post_url'],
            $this->response['post_data'],
            $this->response['header'],
            $this->response['timeout']
        );

        $this->response['post_res'] = $result['res'];
        $this->response['post_time'] = $result['post_time'];

        $res_json = json_decode($result['res']);

        $PercentComplete = $res_json->percentComplete;
        $Status = $res_json->status;
        $Commission = $res_json->commission;
        $RedirectUrl = $res_json->redirectUrl;


        if ($Status == 'MatchFound') {
            $this->response['accept'] = 'ACCEPTED';
            $this->response['post_price'] = $Commission;
            $this->response['post_status'] = '1';
            $this->response['redirect_url'] = $RedirectUrl;

        } else {
            $this->response['accept'] = 'REJECTED';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
        }

        return $this->response;
    }

}


