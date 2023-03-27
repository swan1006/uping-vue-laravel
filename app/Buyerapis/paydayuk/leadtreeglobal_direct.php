<?php



class leadtreeglobal

{

    var $response = array();



    function __construct($client_detail)

    {



		if($_POST['cardType'] == "Solo"){

			$cardType = 'Unknown';

		}elseif($_POST['cardType'] == "SwitchMaestro"){

			$cardType = 'SwitchMaestro';

		}elseif($_POST['cardType'] == "Visa"){

			$cardType = 'Unknown';

		}elseif($_POST['cardType'] == "VisaDebit"){

			$cardType = 'VisaDebit';

		}elseif($_POST['cardType'] == "VisaDelta"){

			$cardType = 'Unknown';

		}elseif($_POST['cardType'] == "VisaElectron"){

			$cardType = 'Unknown';

		}elseif($_POST['cardType'] == "MasterCard"){

			$cardType = 'MasterCard';

		}elseif($_POST['cardType'] == "MasterCardDebit"){

			$cardType = 'MasterCardDebit';

		}





		if($_POST['jobIndustry'] == "Health"){

			$jobIndustry = 'Health';

		}elseif($_POST['jobIndustry'] == "ConstructionManufacturing"){

			$jobIndustry = 'ConstructionManufacturing';

		}elseif($_POST['jobIndustry'] == "BankingInsurance"){

			$jobIndustry = 'Insurance';

		}elseif($_POST['jobIndustry'] == "Education"){

			$jobIndustry = 'Education';

		}elseif($_POST['jobIndustry'] == "HotelRestaurantAndLeisure"){

			$jobIndustry = 'HotelsRestaurantsLeisure';

		}elseif($_POST['jobIndustry'] == "UtilitiesTelecom"){

			$jobIndustry = 'OtherNotOfficeBased';

		}elseif($_POST['jobIndustry'] == "SupermarketRetail"){

			$jobIndustry = 'SupermarketRetail';

		}elseif($_POST['jobIndustry'] == "CivilService"){

			$jobIndustry = 'CivilService';

		}elseif($_POST['jobIndustry'] == "Military"){

			$jobIndustry = 'Military';

		}elseif($_POST['jobIndustry'] == "OtherOfficeBased"){

			$jobIndustry = 'OtherOfficeBased';

		}elseif($_POST['jobIndustry'] == "OtherNotOfficeBased"){

			$jobIndustry = 'OtherNotOfficeBased';

		}elseif($_POST['jobIndustry'] == "DrivingDelivery"){

			$jobIndustry = 'OtherNotOfficeBased';

		}elseif($_POST['jobIndustry'] == "AdministrationSecretarial"){

			$jobIndustry = 'OtherOfficeBased';

		}elseif($_POST['jobIndustry'] == "MidLevelManagement"){

			$jobIndustry = 'OtherOfficeBased';

		}elseif($_POST['jobIndustry'] == "SeniorLevelManagement"){

			$jobIndustry = 'OtherOfficeBased';

		}elseif($_POST['jobIndustry'] == "SeniorLevelManagement"){

			$jobIndustry = 'OtherOfficeBased';

		}elseif($_POST['jobIndustry'] == "SkilledTrade"){

			$jobIndustry = 'OtherNotOfficeBased';

		}elseif($_POST['jobIndustry'] == "Professional"){

			$jobIndustry = 'OtherOfficeBased';

		}



		if($_POST['incomeType'] == "EmployedFullTime"){

			$incomeType = 'FullTime';

		}elseif($_POST['incomeType'] == "EmployedPartTime"){

			$incomeType = 'PartTime';

		}elseif($_POST['incomeType'] == "EmployedTemporary"){

			$incomeType = 'Temporary';

		}elseif($_POST['incomeType'] == "SelfEmployed"){

			$incomeType = 'SelfEmployed';

		}elseif($_POST['incomeType'] == "DisabilityBenefits"){

			$incomeType = 'DisabilityBenefits';

		}elseif($_POST['incomeType'] == "Pension"){

			$incomeType = 'Retired';

		}elseif($_POST['incomeType'] == "Benefits"){

			$incomeType = 'Benefits';

		}


		if($_POST['loanTerms'] == 1){

			$loanTerms = '1';

		}elseif($_POST['loanTerms'] == 3){

			$loanTerms = '3';

		}elseif($_POST['loanTerms'] == 6){

			$loanTerms = '6';

		}elseif($_POST['loanTerms'] == 12){

			$loanTerms = '12';

		}elseif($_POST['loanTerms'] == 24){

			$loanTerms = '24';

		}elseif($_POST['loanTerms'] == 36){

			$loanTerms = '36';

		}



		$dob = explode("-",$_POST['dob']);

		$dob_day = $dob[2];

		$dob_month = $dob[1];

		$dob_year = $dob[0];

		$nextPayDate1 = explode("-",$_POST['nextPayDate1']);

		$nextPayDate1_day = $nextPayDate1[2];

		$nextPayDate1_month = $nextPayDate1[1];

		$nextPayDate1_year = $nextPayDate1[0];

		$nextPayDate2 = explode("-",$_POST['nextPayDate2']);

		$nextPayDate2_day = $nextPayDate2[2];

		$nextPayDate2_month = $nextPayDate2[1];

		$nextPayDate2_year = $nextPayDate2[0];

		if($_POST['stayYear'] == 0) {

			$stayMonth = $_POST['stayMonth'];

		}else {

			$stayMonth = $_POST['stayYear']*12 + $_POST['stayMonth'];
		}

		if($_POST['employmentYear'] == 0) {

			$employmentMonth = $_POST['employmentMonth'];

		}else {

			$employmentMonth = $_POST['employmentYear']*12 + $_POST['employmentMonth'];

		}

		if($_POST['loanPurpose'] == "Subsistence") {

			$loanPurpose = 'Other';

		}elseif($_POST['loanPurpose'] == "OneOffPurchase"){

			$loanPurpose = 'OneOffPurchase';

		}elseif($_POST['loanPurpose'] == "DebtConsolidation"){

			$loanPurpose = 'DebtConsolidation';

		}elseif($_POST['loanPurpose'] == "Other"){

			$loanPurpose = 'Other';

		}elseif($_POST['loanPurpose'] == "CarLoan"){

			$loanPurpose = 'CarLease';

		}elseif($_POST['loanPurpose'] == "PayBills"){

			$loanPurpose = 'UtilityBills';

		}elseif($_POST['loanPurpose'] == "PayOffLoan"){

			$loanPurpose = 'DebtConsolidation';

		}elseif($_POST['loanPurpose'] == "ShortTermCash"){

			$loanPurpose = 'EmergencyCash';

		}elseif($_POST['loanPurpose'] == "HomeImprovements"){

			$loanPurpose = 'HomeImprovements';

		}

		$url = explode("?", $_POST['url']);

		$final_url = $url[0];

		if($client_detail->mode == 1) {

			$mode = "false";

			$TestResponseType = '';

		}else{

			$mode = "true";

			$TestResponseType = 'AcceptedByLenderWithCommission';

		}
        if (isset($_POST['vid'])) {
            $campaign = 'AFF_ID_' . $_POST['vid'];
        }
		else{
            $campaign = 'stagfinance';
        }
        if (isset($_POST['sub_aff_id'])) {
            $sub_aff = 'SUB_AFF_ID_' . $_POST['sub_aff_id'];
        }else{
            $sub_aff = 'DIRECT';

        }
		$postdata = '{

					"AffiliateApiKey": "'.$client_detail->parameter1.'",

					"AffiliateReference": "'.$campaign.'",

					"AffiliateSubReference": "'.$sub_aff.'",

					"AffiliateCampaign": "'.$campaign.'",

					"CreationUrl": "'.$final_url.'",

					"ReferringUrl": "'.$final_url.'",

					"UserAgent": "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)",

					"IpAddress": "'.$_POST['ipaddress'].'",

					"Salutation": "'.$_POST['nameTitle'].'",

					"FirstName": "'.$_POST['firstName'].'",

					"LastName": "'.$_POST['lastName'].'",

					"DateOfBirthDay": "'.$dob_day.'",

					"DateOfBirthMonth": "'.$dob_month.'",

					"DateOfBirthYear": "'.$dob_year.'",

					"MaritalStatus": "'.$_POST['maritalStatus'].'",

					"IsCarOwner": "",

					"NiNumber": "",

					"NationalInsuranceNumberType": "",

					"ConsentToCreditSearch": "true",

					"ConsentToMarketingEmails": "true",

					"ConsentToMarketingSMS": "true",

					"MarketingPreferenceConsent": "Consent",

					"ResidentialCostPerMonth": "'.$_POST['otherExpense'].'",

					"ResidentialStatus": "'.$_POST['rentown'].'",

					"NumberOfDependants": "'.$_POST['dependants'].'",

					"BankAccountNumber": "'.$_POST['bankAccountNumber'].'",

					"BankSortCode": "'.$_POST['bankCode'].'",

					"BankName": "",

					"BankPhoneNumber": "",

					"BankCardType": "'.$cardType.'",

					"HouseNumber": "'.$_POST['houseNumber'].'",

					"Street1": "'.$_POST['street'].' '.$_POST['locality'].'",

					"Street2": "",

					"TownCity": "'.$_POST['city'].'",

					"CountyState": "'.$_POST['county'].'",

					"PostCode": "'.$_POST['zip'].'",

					"CountryCode": "GB",

					"MonthsAtAddress": "'.$stayMonth.'",

					"MobilePhoneNumber": "'.$_POST['mobile'].'",

					"HomePhoneNumber": "'.$_POST['phone'].'",

					"WorkPhoneNumber": "'.$_POST['workPhone'].'",

					"EmailAddress": "'.$_POST['email'].'",

					"BestTimeToCall": "",

					"LoanAmount": "'.$_POST['loanAmount'].'",

					"LoanPurposeType": "'.$loanPurpose.'",

					"LoanTerm": "'.$loanTerms.'",

					"LoanTermType": "Months",

					"EmploymentStatus": "'.$incomeType.'",

					"Occupation": "'.$_POST['jobTitle'].'",

					"EmployerPosition": "NotApplicable",

					"EmployerName": "'.$_POST['employer'].'",

					"EmployerPostCode": "'.$_POST['zip'].'",

					"MonthsWithEmployer": "'.$employmentMonth.'",

					"EmployerIndustry": "'.$jobIndustry.'",

					"Income": "'.$_POST['monthlyIncome'].'",

					"IncomeFrequency": "'.$_POST['incomeCycle'].'",

					"IncomePaymentType": "",

					"NextPayDateDay": "'.$nextPayDate1_day.'",

					"NextPayDateMonth": "'.$nextPayDate1_month.'",

					"NextPayDateYear": "'.$nextPayDate1_year.'",

					"FollowingPayDateDay": "'.$nextPayDate2_day.'",

					"FollowingPayDateMonth": "'.$nextPayDate2_month.'",

					"FollowingPayDateYear": "'.$nextPayDate2_year.'",

					"MonthlyUtilityExpenses": "'.$_POST['monthlyUtilities'].'",

					"MonthlyTransportExpenses": "'.$_POST['monthlyTransport'].'",

					"MonthlyFoodExpenses": "'.$_POST['monthlyFood'].'",

					"ExpenditureConfirmed": "true",

					"OtherMonthlyOutgoings": "'.$_POST['otherExpense'].'",

					"CombinedHouseholdIncome": "",

					"IsTestLead": "'.$mode.'",

					"TestResponseType":"'.$TestResponseType.'"

				}';




		$this->response['post_url'] = ($client_detail->mode == '2') ? $client_detail->post_url_test : $client_detail->post_url_live;
		$this->response['post_url'] = $this->response['post_url'].$client_detail->parameter1;
		$this->response['post_data'] = $postdata;
		$this->response['timeout'] = $client_detail->timeout;
		$this->response['header'] = 'Content-Type: application/json';
    }

    public function returnresponse()
    {
		$result = curl_post(
            $this->response['post_url'],
            $this->response['post_data'],
            $this->response['header'],
            $this->response['timeout']
        );

		$this->response['post_res'] = $result['res'];
		$this->response['post_time'] = $result['post_time'];

		$res_joson = json_decode($result['res']);

		$PercentComplete = $res_joson->percentComplete;
		$Status = $res_joson->status;
		$Commission = $res_joson->commission;
		$RedirectUrl = $res_joson->redirectUrl;


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
