<?php

class zeroparallel
{
    var $response = array();

    function __construct($client_detail)
    {

//        if ($_POST['gender'] == 2) {
//            $gender = 'mr';
//        } else {
//            $gender = 'ms';
//        }

//
//        if ($_POST['cardType'] == 1) {
//            $cardType = 'switch_maestro';
//        } elseif ($_POST['cardType'] == 2) {
//            $cardType = '';
//        } elseif ($_POST['cardType'] == 3) {
//            $cardType = 'visa_delta';
//        } elseif ($_POST['cardType'] == 4) {
//            $cardType = 'visa_debit';
//        } elseif ($_POST['cardType'] == 5) {
//            $cardType = 'visa_electron';
//        } elseif ($_POST['cardType'] == 6) {
//            $cardType = 'master_debit';
//        } elseif ($_POST['cardType'] == 7) {
//            $cardType = 'no_debit_card';
//        }
//
//        if ($_POST['jobIndustry'] == 1) {
//            $jobIndustry = 'construction';
//        } elseif ($_POST['jobIndustry'] == 2) {
//            $jobIndustry = 'military';
//        } elseif ($_POST['jobIndustry'] == 3) {
//            $jobIndustry = 'health';
//        } elseif ($_POST['jobIndustry'] == 4) {
//            $jobIndustry = 'BankingInsurance';
//        } elseif ($_POST['jobIndustry'] == 5) {
//            $jobIndustry = 'education';
//        } elseif ($_POST['jobIndustry'] == 8) {
//            $jobIndustry = 'telecoms_internet';
//        } elseif ($_POST['jobIndustry'] == 9) {
//            $jobIndustry = 'hotels_restaurants';
//        } elseif ($_POST['jobIndustry'] == 12) {
//            $jobIndustry = 'administration_secretarial';
//        } elseif ($_POST['jobIndustry'] == 13) {
//            $jobIndustry = 'manager_mid_level';
//        }


        if ($_POST['incomeType'] == "SelfEmployed") {
            $incomeType = 'EMPLOYMENT';
        } elseif ($_POST['incomeType'] == "EmployedFullTime") {
            $incomeType = 'EMPLOYMENT';
        } elseif ($_POST['incomeType'] == "EmployedPartTime") {
            $incomeType = 'EMPLOYMENT';
        } elseif ($_POST['incomeType'] == "EmployedTemporary") {
            $incomeType = 'EMPLOYMENT';
        } elseif ($_POST['incomeType'] == "Pension") {
            $incomeType = 'BENEFITS';
        } elseif ($_POST['incomeType'] == "DisabilityBenefits") {
            $incomeType = 'BENEFITS';
        } elseif ($_POST['incomeType'] == "Benefits") {
            $incomeType = 'BENEFITS';
        }



//        if ($_POST['rentown'] == 1) {
//            $rentown = 'owner';
//        } elseif ($_POST['rentown'] == 2) {
//            $rentown = 'tenant';
//        } elseif ($_POST['rentown'] == 3) {
//            $rentown = 'council_tenant';
//        } elseif ($_POST['rentown'] == 4) {
//            $rentown = 'living_with_parents';
//        } else {
//            $rentown = 'other';
//        }


//        if ($_POST['maritalStatus'] == 1) {
//            $maritalStatus = 'single';
//        } elseif ($_POST['maritalStatus'] == 2) {
//            $maritalStatus = 'married';
//        } elseif ($_POST['maritalStatus'] == 3) {
//            $maritalStatus = 'living_with_partner';
//        } elseif ($_POST['maritalStatus'] == 4) {
//            $maritalStatus = 'separated';
//        } elseif ($_POST['maritalStatus'] == 5) {
//            $maritalStatus = 'divorced';
//        } elseif ($_POST['maritalStatus'] == 6) {
//            $maritalStatus = 'widowed';
//        } elseif ($_POST['maritalStatus'] == 7) {
//            $maritalStatus = 'other';
//        }

//
//        if ($_POST['bestTimeContact'] == 1) {
//            $bestTimeContact = 'Morning';
//        } elseif ($_POST['bestTimeContact'] == 2) {
//            $bestTimeContact = 'Afternoon';
//        } elseif ($_POST['bestTimeContact'] == 3) {
//            $bestTimeContact = 'Evening';
//        } elseif ($_POST['bestTimeContact'] == 4) {
//            $bestTimeContact = 'Anytime';
//        }


//        if ($_POST['loanTerms'] == 1) {
//            $loanTerms = '1';
//        } elseif ($_POST['loanTerms'] == 3) {
//            $loanTerms = '3';
//        } elseif ($_POST['loanTerms'] == 6) {
//            $loanTerms = '6';
//        } elseif ($_POST['loanTerms'] == 12) {
//            $loanTerms = '12';
//        } elseif ($_POST['loanTerms'] == 24) {
//            $loanTerms = '24';
//        }

//        if ($_POST['incomePaymentType'] == 1) {
////            $incomePaymentType = 'BankTransfer';
////        } elseif ($_POST['incomePaymentType'] == 2) {
////            $incomePaymentType = 'Cheque ';
////        }

//        $dob = explode("-", $_POST['dob']);
//        $dob_day = $dob[2];
//        $dob_month = $dob[1];
//        $dob_year = $dob[0];
//
//        $nextPayDate1 = explode("/", $_POST['nextPayDate1']);
//        $nextPayDate1_day = $nextPayDate1[1];
//        $nextPayDate1_month = $nextPayDate1[0];
//        $nextPayDate1_year = $nextPayDate1[2];
//
//        $nextPayDate2 = explode("/", $_POST['nextPayDate2']);
//        $nextPayDate2_day = $nextPayDate2[1];
//        $nextPayDate2_month = $nextPayDate2[0];
//        $nextPayDate2_year = $nextPayDate2[2];

        $address = explode(" ", $_POST['address']);
        $house_number = $address[0];


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

        if ($employmentMonth > 60) {
            $employmentMonth = "61";
        }

        if ($_POST['incomeCycle'] == "SpecificDayOfMonth") {
            $incomeCycle = 'MONTHLY';
        } elseif ($_POST['incomeCycle'] == "Weekly") {
            $incomeCycle = 'WEEKLY';
        } elseif ($_POST['incomeCycle'] == "BiWeekly") {
            $incomeCycle = 'BIWEEKLY';
        } elseif ($_POST['incomeCycle'] == "Fortnightly") {
            $incomeCycle = 'TWICEMONTHLY';
        } elseif ($_POST['incomeCycle'] == "LastDayMonth") {
            $incomeCycle = 'MONTHLY';
        } elseif ($_POST['incomeCycle'] == "LastWorkingDayMonth") {
            $incomeCycle = 'MONTHLY';
        } elseif ($_POST['incomeCycle'] == "TwiceMonthly") {
            $incomeCycle = 'TWICEMONTHLY';
        } elseif ($_POST['incomeCycle'] == "FourWeekly") {
            $incomeCycle = 'MONTHLY';
        } elseif ($_POST['incomeCycle'] == "LastFriday") {
            $incomeCycle = 'MONTHLY';
        } elseif ($_POST['incomeCycle'] == "LastThursday") {
            $incomeCycle = 'MONTHLY';
        } elseif ($_POST['incomeCycle'] == "LastWednesday") {
            $incomeCycle = 'MONTHLY';
        } elseif ($_POST['incomeCycle'] == "LastTuesday") {
            $incomeCycle = 'MONTHLY';
        } elseif ($_POST['incomeCycle'] == "LastMonday") {
            $incomeCycle = 'MONTHLY';
        }


        if ($_POST['inMilitary'] == 0) {
            $activeMilitary = 'YES';
        } else {
            $activeMilitary = 'NO';
        }

        $address = $_POST['houseNumber'] . ' ' . $_POST['street'] . ' ' . $_POST['locality'];

        if ($_POST['IncomePaymentType'] == 'Cash') {
            $bankDirectDeposit = 'NO';
        } elseif ($_POST['IncomePaymentType'] == 'Cheque') {
            $bankDirectDeposit = 'NO';
        } elseif ($_POST['IncomePaymentType'] == 'RegionalDirectDeposit') {
            $bankDirectDeposit = 'YES';
        }elseif ($_POST['IncomePaymentType'] == 'NonRegionalDirectDeposit') {
            $bankDirectDeposit = 'YES';
        }
        $numberOfMonthsInBank = floor($_POST['bankYear'] * 12 + $_POST['bankMonth']);


        if($_POST['BankAccountType']=='Savings'){
            $bankAccountType = 'SAVING';
        }elseif($_POST['BankAccountType']=='Checking'){
            $bankAccountType = 'CHECKING';

        }

        $postdata = array();
        $postdata['apiId'] = $client_detail->parameter1;
        $postdata['apiPassword'] = $client_detail->parameter2;


        if ($client_detail->mode == '2') {
            $postdata['testmodeca.php'] = 1;
            $postdata['testSold'] = 1;
        }
        $postdata['productId'] = '1';
        $postdata['price'] = $client_detail->tier_price;
        $postdata['loanAmount'] = $_POST['loanAmount'];
        $postdata['workCompanyName'] = $_POST['employer'];
        $postdata['jobTitle'] = $_POST['jobTitle'];
        $postdata['activeMilitary'] = $activeMilitary;
        $postdata['workTimeAtEmployer'] = '';
        $postdata['ssn'] = $_POST['ssn'];
        $postdata['driversLicenseNumber'] = $_POST['DriversLicenseNumber'];
        $postdata['driversLicenseState'] = $_POST['DriversLicenseState'];
        $postdata['incomeType'] = $incomeType;
        $postdata['incomePaymentFrequency'] = $incomeCycle;
        $postdata['incomeNetMonthly'] = $_POST['monthlyIncome'];
        $postdata['incomeNextDate1'] = $_POST['nextPayDate1'];
        $postdata['incomeNextDate2'] = $_POST['nextPayDate2'];
        $postdata['bankDirectDeposit'] = $bankDirectDeposit;
        $postdata['bankAba'] = $_POST['bankCode'];
        $postdata['bankName'] = $_POST['bankName'];
        $postdata['bankPhone'] = '';
        $postdata['bankAccountNumber'] = $_POST['bankAccountNumber'];
        $postdata['bankAccountType'] = $bankAccountType;

        $postdata['bankAccountLengthMonths'] = $numberOfMonthsInBank;
        $postdata['firstName'] = $_POST['firstName'];
        $postdata['lastName'] = $_POST['lastName'];
        $postdata['dob'] = $_POST['dob'];
        $postdata['address'] = $address;
        $postdata['zip'] = $_POST['zip'];
        $postdata['city'] = $_POST['city'];
        $postdata['state'] = $_POST['county'];
        $postdata['ownHome'] = '';
        $postdata['addressLengthMonths'] = '';
        $postdata['email'] = $_POST['email'];
        $postdata['homePhone'] = $_POST['phone'];
        $postdata['workPhone'] = $_POST['workPhone'];
        $postdata['cellPhone'] = $_POST['mobile'];
        $postdata['userIp'] = $_POST['ipaddress'];
        $postdata['userAgent'] = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)';
        $postdata['webSiteUrl'] = $_POST['url'];


        $this->response['post_url'] = ($client_detail->status == '2') ? $client_detail->post_url_test : $client_detail->post_url_live;

        $this->response['post_data'] = http_build_query($postdata);
        $this->response['header'] = array();

        $this->response['tier_price'] = $client_detail->tier_price;

    }


    public function returnresponse()
    {



        $result = curl_post($this->response['post_url'], $this->response['post_data'], $this->response['header'], 60);

        $this->response['post_res'] = $result['res'];

        $final_res = json_decode($result['res']);
        $Price = $final_res->price;
        $status = $final_res->status;
        $redirectUrl = $final_res->redirect_url;

        if ($status == '1') {
            $this->response['accept'] = 'ACCEPTED';
            $this->response['post_price'] = $Price;
            $this->response['post_status'] = '1';
            $this->response['redirect_url'] = $redirectUrl;
        } else {
            $this->response['accept'] = 'REJECTED';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
        }
        //print_r($this->response);exit;
        return $this->response;
    }
}
