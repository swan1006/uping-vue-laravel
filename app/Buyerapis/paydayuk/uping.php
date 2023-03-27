<?php


use App\Helpers\CurlHelper;

class uping
{
    var $response = array();

    function __construct($client_detail, $post)
    {
//        dd($post);




//        if ($_POST['loanPurpose'] == 'Subsistence') {
//            $loanPurpose = 'living_expense';
//        } elseif ($_POST['loanPurpose'] == 'OneOffPurchase') {
//            $loanPurpose = 'emergency_cash';
//        } elseif ($_POST['loanPurpose'] == 'DebtConsolidation') {
//            $loanPurpose = 'debt_consolidation';
//        } elseif ($_POST['loanPurpose'] == 'CarLoan') {
//            $loanPurpose = 'vehicle';
//        } elseif ($_POST['loanPurpose'] == 'PayBills') {
//            $loanPurpose = 'utility_bill';
//        } elseif ($_POST['loanPurpose'] == 'PayOffLoan') {
//            $loanPurpose = 'rent_mortgage';
//        } elseif ($_POST['loanPurpose'] == 'ShortTermCash') {
//            $loanPurpose = 'emergency_cash';
//        } elseif ($_POST['loanPurpose'] == 'HomeImprovements') {
//            $loanPurpose = 'home_improvement';
//        } elseif ($_POST['loanPurpose'] == 'Other') {
//            $loanPurpose = 'other';
//        } else {
//            $loanPurpose = 'other';
//        }
//
//
//        if ($_POST['nameTitle'] == 'Mr') {
//            $nameTitle = 'mr';
//        } elseif ($_POST['nameTitle'] == 'Miss') {
//            $nameTitle = 'miss';
//        } elseif ($_POST['nameTitle'] == 'Mrs') {
//            $nameTitle = 'mrs';
//        } elseif ($_POST['nameTitle'] == 'Ms') {
//            $nameTitle = 'ms';
//        }
//
//        if ($_POST['rentown'] == "HomeOwner") {
//            $rentown = 'owner';
//        } elseif ($_POST['rentown'] == "PrivateTenant") {
//            $rentown = 'tenant';
//        } elseif ($_POST['rentown'] == "CouncilTenant") {
//            $rentown = 'council_tenant';
//        } elseif ($_POST['rentown'] == "LivingWithParents") {
//            $rentown = 'living_with_parents';
//        } elseif ($_POST['rentown'] == "LivingWithFriends") {
//            $rentown = 'other';
//        } elseif ($_POST['rentown'] == "Other") {
//            $rentown = 'other';
//        }
//
//
//        if ($_POST['maritalStatus'] == "Married") {
//            $maritalStatus = 'married';
//        } elseif ($_POST['maritalStatus'] == "LivingTogether") {
//            $maritalStatus = 'living_with_partner';
//        } elseif ($_POST['maritalStatus'] == "Single") {
//            $maritalStatus = 'single';
//        } elseif ($_POST['maritalStatus'] == "Separated") {
//            $maritalStatus = 'separated';
//        } elseif ($_POST['maritalStatus'] == "Divorced") {
//            $maritalStatus = 'divorced';
//        } elseif ($_POST['maritalStatus'] == "Widowed") {
//            $maritalStatus = 'widowed';
//        } elseif ($_POST['maritalStatus'] == "Other") {
//            $maritalStatus = 'other';
//
//        }
//
//
//        if ($_POST['incomeType'] == "SelfEmployed") {
//            $incomeType = 'self_employed';
//        } elseif ($_POST['incomeType'] == "EmployedFullTime") {
//            $incomeType = 'full_time';
//        } elseif ($_POST['incomeType'] == "EmployedPartTime") {
//            $incomeType = 'part_time';
//        } elseif ($_POST['incomeType'] == "EmployedTemporary") {
//            $incomeType = 'temporary_employment';
//        } elseif ($_POST['incomeType'] == "Pension") {
//            $incomeType = 'pension';
//        } elseif ($_POST['incomeType'] == "DisabilityBenefits") {
//            $incomeType = 'disability_benefit';
//        } elseif ($_POST['incomeType'] == "Benefits") {
//            $incomeType = 'student';
//        }
//
//
//
//        if ($_POST['jobIndustry'] == "ConstructionManufacturing") {
//            $jobIndustry = 'construction';
//        } elseif ($_POST['jobIndustry'] == "Military") {
//            $jobIndustry = 'military';
//        } elseif ($_POST['jobIndustry'] == "Health") {
//            $jobIndustry = 'health';
//        } elseif ($_POST['jobIndustry'] == "BankingInsurance") {
//            $jobIndustry = 'insurance';
//        } elseif ($_POST['jobIndustry'] == "Education") {
//            $jobIndustry = 'education';
//        } elseif ($_POST['jobIndustry'] == "CivilService") {
//            $jobIndustry = 'public_administration';
//        } elseif ($_POST['jobIndustry'] == "SupermarketRetail") {
//            $jobIndustry = 'retail';
//        } elseif ($_POST['jobIndustry'] == "UtilitiesTelecom") {
//            $jobIndustry = 'telecoms_internet';
//        } elseif ($_POST['jobIndustry'] == "HotelRestaurantAndLeisure") {
//            $jobIndustry = 'hotels_restaurants';
//        } elseif ($_POST['jobIndustry'] == "OtherOfficeBased") {
//            $jobIndustry = 'other';
//        } elseif ($_POST['jobIndustry'] == "OtherNotOfficeBased") {
//            $jobIndustry = 'other';
//        } elseif ($_POST['jobIndustry'] == "DrivingDelivery") {
//            $jobIndustry = 'transportation';
//        } elseif ($_POST['jobIndustry'] == "AdministrationSecretarial") {
//            $jobIndustry = 'administration_secretarial';
//        } elseif ($_POST['jobIndustry'] == "MidLevelManagement") {
//            $jobIndustry = 'manager_mid_level';
//        } elseif ($_POST['jobIndustry'] == "SeniorLevelManagement") {
//            $jobIndustry = 'manager_senior_level';
//        } elseif ($_POST['jobIndustry'] == "SkilledTrade") {
//            $jobIndustry = 'skilled_trade';
//        } elseif ($_POST['jobIndustry'] == "Professional") {
//            $jobIndustry = 'professional';
//        } else {
//            $jobIndustry = 'other';
//
//        }
//
//
//        if ($_POST['cardType'] == "Solo") {
//            $cardType = 'switch_maestro';
//        } elseif ($_POST['cardType'] == "SwitchMaestro") {
//            $cardType = 'switch_maestro';
//        } elseif ($_POST['cardType'] == "Visa") {
//            $cardType = 'visa_electron';
//        } elseif ($_POST['cardType'] == "VisaDebit") {
//            $cardType = 'visa_debit';
//        } elseif ($_POST['cardType'] == "VisaDelta") {
//            $cardType = 'visa_delta';
//        } elseif ($_POST['cardType'] == "VisaElectron") {
//            $cardType = 'visa_electron';
//        } elseif ($_POST['cardType'] == "MasterCard") {
//            $cardType = 'master_debit';
//        } elseif ($_POST['cardType'] == "MasterCardDebit") {
//            $cardType = 'master_debit';
//        }
//
//
//        if ($_POST['stayYear'] == 0) {
//            $stayMonth = $_POST['stayMonth'];
//        } else {
//            $stayMonth = $_POST['stayYear'] * 12 + $_POST['stayMonth'];
//        }
//        if ($stayMonth > 60) {
//            $stayMonth = "61";
//        }
//
//
//        if ($_POST['employmentYear'] == 0) {
//            $employmentMonth = $_POST['employmentMonth'];
//        } else {
//            $employmentMonth = $_POST['employmentYear'] * 12 + $_POST['employmentMonth'];
//        }
//
//        if ($employmentMonth > 60) {
//            $employmentMonth = "61";
//        }
//
//
//        if ($_POST['incomeCycle'] == "SpecificDayOfMonth") {
//            $incomeCycle = 'specific_day_of_month';
//        } elseif ($_POST['incomeCycle'] == "Weekly") {
//            $incomeCycle = 'weekly';
//        } elseif ($_POST['incomeCycle'] == "BiWeekly") {
//            $incomeCycle = 'semi_monthly';
//        } elseif ($_POST['incomeCycle'] == "Fortnightly") {
//            $incomeCycle = 'fortnightly';
//        } elseif ($_POST['incomeCycle'] == "LastDayMonth") {
//            $incomeCycle = 'last_working_day_of_month';
//        } elseif ($_POST['incomeCycle'] == "LastWorkingDayMonth") {
//            $incomeCycle = 'last_working_day_of_month';
//        } elseif ($_POST['incomeCycle'] == "TwiceMonthly") {
//            $incomeCycle = 'semi_monthly';
//        } elseif ($_POST['incomeCycle'] == "FourWeekly") {
//            $incomeCycle = 'four_weekly';
//        } elseif ($_POST['incomeCycle'] == "LastFriday") {
//            $incomeCycle = 'last_friday_of_month';
//        } elseif ($_POST['incomeCycle'] == "LastThursday") {
//            $incomeCycle = 'last_thursday_of_month';
//        } elseif ($_POST['incomeCycle'] == "LastWednesday") {
//            $incomeCycle = 'last_wednesday_of_month';
//        } elseif ($_POST['incomeCycle'] == "LastTuesday") {
//            $incomeCycle = 'last_tuesday_of_month';
//        } elseif ($_POST['incomeCycle'] == "LastMonday") {
//            $incomeCycle = 'last_monday_of_month';
//        }
//
//
//        if ($_POST['agreeCreditCheck'] == 'true') {
//            $thirdPartyEmail = 1;
//        } else {
//            $thirdPartyEmail = 0;
//        }
//        if ($_POST['terms2'] == 'true') {
//            $thirdPartyPhone = 1;
//        } else {
//            $thirdPartyPhone = 0;
//        }
//        if ($_POST['terms3'] == 'true') {
//            $thirdPartyTextMessage = 1;
//        } else {
//            $thirdPartyTextMessage = 0;
//        }

        $postdata = array();
//        $postdata['apiId'] = $client_detail->parameter1;
//        $postdata['apiPassword'] = $client_detail->parameter2;
//
//
//        if ($client_detail->mode == '2') {
//            $postdata['testmodeca.php'] = 1;
//            $postdata['testSold'] = 1;
//        }

        $postdata['productId'] = '4';
        $postdata['price'] = $client_detail->tier_price;
        $postdata['loanAmount'] = '1000';
//        $postdata['loanDurationMonths'] = $_POST['loanTerms'];
//        $postdata['loanPurpose'] = $_POST['loanPurpose'];
//        $postdata['title'] = $_POST['nameTitle'];
//        $postdata['firstName'] = $_POST['firstName'];
//        $postdata['lastName'] = $_POST['lastName'];
//        $postdata['middleName'] = $_POST['lastName'];
//        $postdata['dob'] = $_POST['dateOfBirth'];
//        $postdata['maritalStatus'] = $_POST['maritalStatus'];
//        $postdata['numberOfDependents'] = $_POST['dependants'];
//        $postdata['houseNumber'] = $_POST['houseNumber'];
//        $postdata['houseName'] = '';
//        $postdata['flatNumber'] = '';
//        $postdata['street'] = $_POST['addressStreet1'];
//        $postdata['city'] = $_POST['city'];
//        $postdata['postCode'] = $_POST['postCode'];
//        $postdata['county'] = $_POST['county'];
//        $postdata['residentialStatus'] = $_POST['residentialStatus'];
//        $postdata['monthsAtAddress'] = $_POST['monthsAtAddress'];
//        $postdata['homePhone'] = $_POST['homePhoneNumber'];
//        $postdata['workPhone'] = $_POST['workPhoneNumber'];
//        $postdata['cellPhone'] = $_POST['mobilePhoneNumber'];
//        $postdata['email'] = $_POST['email'];
//        $postdata['incomeType'] = $_POST['incomeSource'];
//        $postdata['incomePaymentFrequency'] = $_POST['incomeCycle'];
//        $postdata['incomeNextDate1'] = $_POST['nextPayDate1'];
//        $postdata['incomeNextDate2'] = $_POST['nextPayDate2'];
//        $postdata['workCompanyName'] = $_POST['employer'];
//        $postdata['workIndustry'] = $_POST['employerIndustry'];
//        $postdata['workTimeAtEmployer'] = $_POST['employmentMonth'];
//        $postdata['workPosition'] = '';
//        $postdata['incomeNetMonthly'] = $_POST['monthlyIncome'];
//        $postdata['expenseHousing'] = $_POST['monthlyMortgageRent'];
//        $postdata['expenseAllLoans'] = $_POST['monthlyRepayments'];
//        $postdata['expenseFood'] = $_POST['monthlyFood'];
//        $postdata['expenseUtilities'] = $_POST['monthlyUtilities'];
//        $postdata['expenseTransport'] = $_POST['monthlyTransport'];
//        $postdata['expenseOther'] = $_POST['otherExpense'];
//        $postdata['bankName'] = $_POST['bankName'];
//        $postdata['bankSortCode'] = $_POST['bankCode'];
//        $postdata['bankAccountNumber'] = $_POST['bankAccountNumber'];
//        $postdata['bankDirectDeposit'] = '1';
//        $postdata['bankDebitCardType'] = $_POST['bankCardType'];
//        $postdata['consentCreditSearch'] = '1';
//        $postdata['consentFinancial'] = '1';
//        $postdata['thirdPartyEmail'] = $_POST['consentThirdPartyEmails'];
//        $postdata['thirdPartyTextMessage'] = $_POST['consentThirdPartySMS'];
//        $postdata['thirdPartyPhone'] = $_POST['consentThirdPartyPhone'];
//        $postdata['userAgent'] =  htmlspecialchars($_POST['browser'], ENT_QUOTES);
//        $postdata['userIp'] = $_POST['ipaddress'];


        $this->response['post_url'] = ($client_detail->status == '2') ? $client_detail->post_url_test : $client_detail->post_url_live;
        $this->response['post_data'] = http_build_query($postdata);
        $this->response['header'] = array();
        $this->response['timeout'] = $client_detail->timeout;

    }


    public function returnresponse()
    {
        $result = (new App\Helpers\CurlHelper)->curl_post(
            $this->response['post_url'],
            $this->response['post_data'],
            $this->response['header'],
            $this->response['timeout']
        );
//        dd($result);

        $this->response['post_res'] = $result['res'];
        $this->response['post_time'] = $result['post_time'];

        preg_match("/<RedirectURL>(.*)<\/RedirectURL>/", $result['res'], $Redirect_url);
        preg_match("/<Result>(.*)<\/Result>/", $result['res'], $Status);
        preg_match("/<Payout>(.*)<\/Payout>/", $result['res'], $Amount);

        if (count($Status) != 0 && $Status[1] == '1') {
            $this->response['accept'] = 'ACCEPTED';
            $this->response['post_price'] = $Amount[1];
            $this->response['post_status'] = '1';
            $this->response['redirect_url'] = $Redirect_url[1];

            return $this->response;

        } else {
            $this->response['accept'] = 'REJECTED';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';

            return $this->response;
        }
    }

    public function CheckStatus($res){

        preg_match("/<CorrelationId>(.*)<\/CorrelationId>/", $res, $CorrelationId);
        preg_match("/<StatusCheckUrl>(.*)<\/StatusCheckUrl>/", $res, $StatusCheckUrl);

        $url = "http://127.0.0.1:8000/application/status/".$StatusCheckUrl[1];
        //echo $url;
        $url_response = file_get_contents($url);//die;
        //echo '13';print_r($url_response);die;

        preg_match("/<PercentageComplete>(.*)<\/PercentageComplete>/", $url_response, $PercentageComplete);
        preg_match("/<Status>(.*)<\/Status>/", $url_response, $Status);
        preg_match("/<Amount>(.*)<\/Amount>/", $url_response, $Amount);
        preg_match("/<RedirectionUrl>(.*)<\/RedirectionUrl>/", $url_response, $RedirectionUrl);




        $this->responses['post_res'] = $url_response;

        if ($Status[1] == 'LenderMatchFound') {
            $this->responses['accept'] = 'ACCEPTED';
            $this->responses['post_price'] = $Amount[1];
            $this->responses['post_status'] = '1';
            $this->responses['redirect_url'] = $RedirectionUrl[1];
            $this->responses['percentage'] = $PercentageComplete[1];
            $this->responses['status'] = $Status[1];

        } else {
            $this->responses['accept'] = 'REJECTED';
            $this->responses['post_status'] = '0';
            $this->responses['post_price'] = '0';
            $this->responses['percentage'] = $PercentageComplete[1];
            $this->responses['status'] = $Status[1];
        }
        //print_r($this->response);exit;
        return $this->responses;

    }
}
