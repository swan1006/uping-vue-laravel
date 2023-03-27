<?php

class monevo
{
    var $response = array();

    function __construct($client_detail)
    {

//		print_r($_POST);echo '<br/><br/>';//die;
//		print_r($client_detail);die;


        if ($_POST['loanPurpose'] == 'Subsistence') {
            $loanPurpose = '18';
        } elseif ($_POST['loanPurpose'] == 'OneOffPurchase') {
            $loanPurpose = '21';
        } elseif ($_POST['loanPurpose'] == 'DebtConsolidation') {
            $loanPurpose = '7';
        } elseif ($_POST['loanPurpose'] == 'CarLoan') {
            $loanPurpose = '2';
        } elseif ($_POST['loanPurpose'] == 'PayBills') {
            $loanPurpose = '18';
        } elseif ($_POST['loanPurpose'] == 'PayOffLoan') {
            $loanPurpose = '18';
        } elseif ($_POST['loanPurpose'] == 'ShortTermCash') {
            $loanPurpose = '19';
        } elseif ($_POST['loanPurpose'] == 'HomeImprovements') {
            $loanPurpose = '9';
        } elseif ($_POST['loanPurpose'] == 'Other') {
            $loanPurpose = '18';
        }

        if ($_POST['nameTitle'] == "Mr") {
            $Gender = 'M';
        } else {
            $Gender = 'F';
        }

        if ($_POST['maritalStatus'] == "Married") {
            $maritalStatus = '1';
        } elseif ($_POST['maritalStatus'] == "LivingTogether") {
            $maritalStatus = '2';
        } elseif ($_POST['maritalStatus'] == "Single") {
            $maritalStatus = '3';
        } elseif ($_POST['maritalStatus'] == "Separated") {
            $maritalStatus = '5';
        } elseif ($_POST['maritalStatus'] == "Divorced") {
            $maritalStatus = '6';
        } elseif ($_POST['maritalStatus'] == "Widowed") {
            $maritalStatus = '8';
        } elseif ($_POST['maritalStatus'] == "Other") {
            $maritalStatus = '7';
        }

        if ($_POST['rentown'] == "HomeOwner") {
            $rentown = '10';
        } elseif ($_POST['rentown'] == "PrivateTenant") {
            $rentown = '7';
        } elseif ($_POST['rentown'] == "CouncilTenant") {
            $rentown = '9';
        } elseif ($_POST['rentown'] == "LivingWithParents") {
            $rentown = '6';
        } elseif ($_POST['rentown'] == "LivingWithFriends") {
            $rentown = '5';
        } elseif ($_POST['rentown'] == "Other") {
            $rentown = '4';
        }

        if ($_POST['stayYear'] == 0) {
            $stayMonth = $_POST['stayMonth'];
        } else {
            $stayMonth = $_POST['stayYear'] * 12 + $_POST['stayMonth'];
        }

        if ($_POST['employmentYear'] == 0) {
            $employmentMonth = $_POST['employmentMonth'];
        } else {
            $employmentMonth = $_POST['employmentYear'] * 12 + $_POST['employmentMonth'];
        }

        if ($_POST['incomeType'] == "SelfEmployed") {
            $incomeType = '3';
        } elseif ($_POST['incomeType'] == "EmployedFullTime") {
            $incomeType = '1';
        } elseif ($_POST['incomeType'] == "EmployedPartTime") {
            $incomeType = '2';
        } elseif ($_POST['incomeType'] == "EmployedTemporary") {
            $incomeType = '4';
        } elseif ($_POST['incomeType'] == "Pension") {
            $incomeType = '6';
        } elseif ($_POST['incomeType'] == "DisabilityBenefits") {
            $incomeType = '7';
        } elseif ($_POST['incomeType'] == "Benefits") {
            $incomeType = '8';
        }

        if ($_POST['jobIndustry'] == "ConstructionManufacturing") {
            $jobIndustry = '7';
        } elseif ($_POST['jobIndustry'] == "Military") {
            $jobIndustry = '17';
        } elseif ($_POST['jobIndustry'] == "Health") {
            $jobIndustry = '11';
        } elseif ($_POST['jobIndustry'] == "BankingInsurance") {
            $jobIndustry = '13';
        } elseif ($_POST['jobIndustry'] == "Education") {
            $jobIndustry = '8';
        } elseif ($_POST['jobIndustry'] == "CivilService") {
            $jobIndustry = '19';
        } elseif ($_POST['jobIndustry'] == "SupermarketRetail") {
            $jobIndustry = '23';
        } elseif ($_POST['jobIndustry'] == "UtilitiesTelecom") {
            $jobIndustry = '24';
        } elseif ($_POST['jobIndustry'] == "HotelRestaurantAndLeisure") {
            $jobIndustry = '12';
        } elseif ($_POST['jobIndustry'] == "OtherOfficeBased") {
            $jobIndustry = '26';
        } elseif ($_POST['jobIndustry'] == "OtherNotOfficeBased") {
            $jobIndustry = '26';
        } elseif ($_POST['jobIndustry'] == "DrivingDelivery") {
            $jobIndustry = '25';
        } elseif ($_POST['jobIndustry'] == "AdministrationSecretarial") {
            $jobIndustry = '19';
        } elseif ($_POST['jobIndustry'] == "MidLevelManagement") {
            $jobIndustry = '26';
        } elseif ($_POST['jobIndustry'] == "SeniorLevelManagement") {
            $jobIndustry = '26';
        } elseif ($_POST['jobIndustry'] == "SkilledTrade") {
            $jobIndustry = '26';
        } elseif ($_POST['jobIndustry'] == "Professional") {
            $jobIndustry = '26';
        } else {
            $jobIndustry = '26';
        }

        if ($_POST['incomeCycle'] == "SpecificDayOfMonth") {
            $incomePayFrequency = '4';
        } elseif ($_POST['incomeCycle'] == "Weekly") {
            $incomePayFrequency = '1';
        } elseif ($_POST['incomeCycle'] == "BiWeekly") {
            $incomePayFrequency = '2';
        } elseif ($_POST['incomeCycle'] == "Fortnightly") {
            $incomePayFrequency = '3';
        } elseif ($_POST['incomeCycle'] == "LastDayMonth") {
            $incomePayFrequency = '4';
        } elseif ($_POST['incomeCycle'] == "LastWorkingDayMonth") {
            $incomePayFrequency = '4';
        } elseif ($_POST['incomeCycle'] == "TwiceMonthly") {
            $incomePayFrequency = '3';
        } elseif ($_POST['incomeCycle'] == "FourWeekly") {
            $incomePayFrequency = '4';
        } elseif ($_POST['incomeCycle'] == "LastFriday") {
            $incomePayFrequency = '1';
        } elseif ($_POST['incomeCycle'] == "LastThursday") {
            $incomePayFrequency = '1';
        } elseif ($_POST['incomeCycle'] == "LastWednesday") {
            $incomePayFrequency = '1';
        } elseif ($_POST['incomeCycle'] == "LastTuesday") {
            $incomePayFrequency = '1';
        } elseif ($_POST['incomeCycle'] == "LastMonday") {
            $incomePayFrequency = '1';
        }

        if ($_POST['cardType'] == "Solo") {
            $cardType = '7';
        } elseif ($_POST['cardType'] == "SwitchMaestro") {
            $cardType = '2';
        } elseif ($_POST['cardType'] == "Visa") {
            $cardType = '7';
        } elseif ($_POST['cardType'] == "VisaDebit") {
            $cardType = '5';
        } elseif ($_POST['cardType'] == "VisaDelta") {
            $cardType = '7';
        } elseif ($_POST['cardType'] == "VisaElectron") {
            $cardType = '4';
        } elseif ($_POST['cardType'] == "MasterCard") {
            $cardType = '7';
        } elseif ($_POST['cardType'] == "MasterCardDebit") {
            $cardType = '8';
        }

        if ($_POST['agreeCreditCheck'] == '1') {
            $terms_consent = '1';
        } else {
            $terms_consent = '0';
        }

        $url = explode("?", $_POST['url']);
        $final_url = $url[0];

        if ($client_detail->mode == 1) {
            $mode = "LIVE";
            $this->response['mode'] = 'LIVE';
        } else {
            $mode = "TEST";
            $this->response['mode'] = 'TEST';

        }
        $postdata = array(
            'campaign_code' => $client_detail->parameter1,
            'mode' => $mode,
            'min_commission' => '',
            'max_commission' => '',
            'affiliate_app_id' => $client_detail->parameter2,
            'loan_amount' => $_POST['loanAmount'],
            'loan_purpose' => $loanPurpose,
            'loan_term' => $_POST['loanTerms'],
            'first_name' => $_POST['firstName'],
            'last_name' => $_POST['lastName'],
            'gender' => $Gender,
            'dob' => $_POST['dob'],
            'marital_status' => $maritalStatus,
            'dependent_number' => $_POST['dependants'],
            'email' => $_POST['email'],
            'home_phone' => $_POST['phone'],
            'mobile_phone' => $_POST['mobile'],
            'residence_type' => $rentown,
            'postcode' => $_POST['zip'],
            'address1' => $_POST['houseNumber'],
            'address2' => $_POST['street'] . ' ' . $_POST['locality'],
            'city' => $_POST['city'],
            'county' => $_POST['county'],
            'months_at_address' => $stayMonth,
            'prev_residence_type' => '',
            'prev_postcode' => '',
            'prev_address1' => '',
            'prev_address2' => '',
            'prev_city' => '',
            'prev_county' => '',
            'prev_months_at_address' => '',
            'home_value' => '',
            'remaining_mortgage' => '',
            'mortgage_age' => '',
            'time_at_bank' => '',
            'income_source' => $incomeType,
            'employer_name' => $_POST['employer'],
            'work_phone' => $_POST['workPhone'],
            'months_at_employer' => $employmentMonth,
            'monthly_income' => $_POST['monthlyIncome'],
            'employment_industry' => $jobIndustry,
            'income_pay_frequency' => $incomePayFrequency,
            'income_payment_type' => 1,
            'next_pay_date' => $_POST['nextPayDate1'],
            'has_pension' => 0,
            'has_other_household_income' => '',
            'benefits' => '',
            'rental_income' => '',
            'pension_income' => '',
            'additional_job_income' => '',
            'other_income' => '',
            'rental_mortgage_payments' => $_POST['mortrent'],
            'existing_loan_payments' => $_POST['monthlyRepayments'],
            'other_expenses' => $_POST['otherExpense'],
            'bills' => $_POST['monthlyUtilities'],
            'transport' => $_POST['monthlyTransport'],
            'food' => $_POST['monthlyFood'],
            'bank_account_type' => $cardType,
            'bank_account_number' => $_POST['bankAccountNumber'],
            'bank_sort_code' => $_POST['bankCode'],
            'marketing_opt_in' => 1,
            'terms_consent' => $terms_consent,
            'site_url' => $final_url,
            'site_ip' => '185.136.232.210',
            'client_ip' => $_POST['ipaddress'],
            'client_agent' => htmlspecialchars($_POST['browser'], ENT_QUOTES),
            'ref' => '',
            'keyword' => '',
            'match_type' => '',
            'network' => '',
            'device' => '',
            'v1-v5' => '',
            'i1-i5' => '',
            'opt_sms' => '',
            'opt_email' => '',
            'opt_phone' => '',
            'opt_post' => ''
        );

        $this->response['post_url'] = ($client_detail->mode == '2') ? $client_detail->post_url_test : $client_detail->post_url_live;
        $this->response['post_data'] = http_build_query($postdata);
        $this->response['timeout'] = $client_detail->timeout;
        $this->response['header'] = array();

    }


    public function returnresponse()
    {


        $result = curl_post($this->response['post_url'], $this->response['post_data'], $this->response['header'], $this->response['timeout']);


        $this->response['post_res'] = $result['res'];
        $this->response['post_time'] = $result['post_time'];

        preg_match("/<redirect_url>(.*)<\/redirect_url>/", $result['res'], $Redirect_url);
        preg_match("/<status>(.*)<\/status>/", $result['res'], $Status);
        preg_match("/<result>(.*)<\/result>/", $result['res'], $Result);
        preg_match("/<reference>(.*)<\/reference>/", $result['res'], $Reference);
        preg_match("/<commission>(.*)<\/commission>/", $result['res'], $Amount);


        if ($this->response['mode'] = "TEST" && $Result[1] == '22') {
            $Amount[0] = "TestAmount";
            $Amount[1] = "0.1";
        }


        if ($Result[1] == '20' || ($this->response['mode'] = "TEST" && $Result[1] == '22')) {
            $this->response['accept'] = 'ACCEPTED';
            $this->response['post_price'] = $Amount[1];
            $this->response['post_status'] = '1';
            $this->response['redirect_url'] = $Redirect_url[1];

        } else {
            $this->response['accept'] = 'REJECTED';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
        }
        return $this->response;

    }
}
