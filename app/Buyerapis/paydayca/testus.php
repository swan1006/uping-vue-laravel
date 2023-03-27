<?php



class testus

{

    var $response = array();

   

    function __construct($client_detail)

    {

	

//		print_r($_POST);echo '<br/><br/>';//die;

//		print_r($client_detail);die;

		

		

		if($_POST['loanPurpose'] == 'car_loan'){

			$loanPurpose = '2';

		}elseif($_POST['loanPurpose'] == 'pay_bills') {

			$loanPurpose = '10';

		}elseif($_POST['loanPurpose'] == 'debt_consolidation') {

			$loanPurpose = '7';

		}elseif($_POST['loanPurpose'] == 'home_improvements') {

			$loanPurpose = '9';

		}elseif($_POST['loanPurpose'] == 'short_term_cash') {

			$loanPurpose = '19';

		}elseif($_POST['loanPurpose'] == 'other') {

			$loanPurpose = '18';

		}

		

		if($_POST['gender'] == 2) {

			$gender = 'M';

		}else {

			$gender = 'F';

		}

				

		if($_POST['maritalStatus'] == 1){

			$maritalStatus = '3';

		}elseif($_POST['maritalStatus'] == 2){

			$maritalStatus = '1';

		}elseif($_POST['maritalStatus'] == 3){

			$maritalStatus = '2';

		}elseif($_POST['maritalStatus'] == 4){

			$maritalStatus = '5';

		}elseif($_POST['maritalStatus'] == 5){

			$maritalStatus = '6';

		}elseif($_POST['maritalStatus'] == 6){

			$maritalStatus = '8';

		}elseif($_POST['maritalStatus'] == 7){

			$maritalStatus = '7';

		}

		

		if($_POST['rentown'] == 1){

			$rentown = '1';

		}elseif($_POST['rentown'] == 2){

			$rentown = '7';

		}elseif($_POST['rentown'] == 3){

			$rentown = '9';

		}elseif($_POST['rentown'] == 4){

			$rentown = '6';

		}

				

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

		

		if($_POST['incomeType'] == 1){

			$incomeType = '1';

		}elseif($_POST['incomeType'] == 2){

			$incomeType = '2';

		}elseif($_POST['incomeType'] == 3){

			$incomeType = '4';

		}elseif($_POST['incomeType'] == 4){

			$incomeType = '3';

		}elseif($_POST['incomeType'] == 5){

			$incomeType = '5';

		}elseif($_POST['incomeType'] == 6){

			$incomeType = '6';

		}elseif($_POST['incomeType'] == 7){

			$incomeType = '7';

		}elseif($_POST['incomeType'] == 8){

			$incomeType = '8';

		}

		

		if($_POST['jobIndustry'] == 1){

			$jobIndustry = '7';

		}elseif($_POST['jobIndustry'] == 2){

			$jobIndustry = '17';

		}elseif($_POST['jobIndustry'] == 3){

			$jobIndustry = '11';

		}elseif($_POST['jobIndustry'] == 4){

			$jobIndustry = '13';

		}elseif($_POST['jobIndustry'] == 5){

			$jobIndustry = '8';

		}elseif($_POST['jobIndustry'] == 6){

			$jobIndustry = '14';

		}elseif($_POST['jobIndustry'] == 7){

			$jobIndustry = '23';

		}elseif($_POST['jobIndustry'] == 8){

			$jobIndustry = '24';

		}elseif($_POST['jobIndustry'] == 9){

			$jobIndustry = '12';

		}elseif($_POST['jobIndustry'] == 10){

			$jobIndustry = '26';

		}elseif($_POST['jobIndustry'] == 11){

			$jobIndustry = '26';

		}elseif($_POST['jobIndustry'] == 12){

			$jobIndustry = '26';

		}elseif($_POST['jobIndustry'] == 13){

			$jobIndustry = '26';

		}

		

		

		if($_POST['cardType'] == 1){

			$cardType = '2';

		}elseif($_POST['cardType'] == 4){

			$cardType = '5';

		}elseif($_POST['cardType'] == 5){

			$cardType = '4';

		}elseif($_POST['cardType'] == 6){

			$cardType = '8';

		}elseif($_POST['cardType'] == 7){

			$cardType = '7';

		}

		

		if($_POST['agreeCreditCheck'] == 'true ') {

			$terms_consent = '1';

		}else{

			$terms_consent = '0';

		}

		

					

		$postdata = array('campaign_code' => $client_detail->parameter1,

						'mode' => $client_detail->parameter2,

						'min_commission' => '',

						'max_commission' => '',

						'affiliate_app_id' => $client_detail->parameter3,		

						'loan_amount' => $_POST['loanAmount'],

						'loan_purpose' => $loanPurpose,

						'loan_term' => $_POST['loanTerms'],

						'first_name' => $_POST['firstName'],

						'last_name' => $_POST['lastName'],

						'gender' => $gender,

						'dob' => $_POST['dob'],

						'marital_status' => $maritalStatus,

						'dependent_number' => $_POST['no_of_dependents'],

						'email' => $_POST['email'],

						'home_phone' => $_POST['phone'],

						'mobile_phone' => $_POST['mobile'],

						'residence_type' => $rentown,

						'postcode' => $_POST['zip'],

						'address1' => $_POST['house'],

						'address2' => $_POST['address'],

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

						'income_pay_frequency' => $_POST['incomeCycle'],

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

						'existing_loan_payments' => $_POST['commit'],

						'other_expenses' => $_POST['otherExpense'],

						'bills' => $_POST['monthlyUtilities'],

						'transport' => $_POST['monthlyTransport'],

						'food' => $_POST['monthlyFood'],

						'bank_account_type' => $cardType,

						'bank_account_number' => $_POST['bankAccountNumber'],

						'bank_sort_code' => $_POST['bankCode'],

						'marketing_opt_in' => 1,

						'terms_consent' => $terms_consent,

						'site_url' => $_POST['url'],

						'site_ip' => '185.136.232.210',

						'client_ip' => $_POST['ipaddress'],

						'client_agent' => '',

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

						 

//		print_r($postdata);	die;

//		print_r(http_build_query($postdata));die;

		$this->response['post_url'] = ($client_detail->mode == '2') ? $client_detail->post_url_test : $client_detail->post_url_live;						 

		$this->response['post_data'] = http_build_query($postdata);

//		$this->response['header'] = 'Content-type: text/xml; charset=utf-8';

		$this->response['header'] = array();

		

//		print_r($this->response['post_url']);echo '<br/>';

//		print_r($this->response['post_data']);echo '<br/>';die;

//		print_r($this->response);die;

    }





    public function returnresponse()

    {		

		$result = curl_post($this->response['post_url'], $this->response['post_data'], $this->response['header'], $client_detail->timeout);  

		

//		print_r($result['res']);die;

		$this->response['post_res'] = $result['res'];

		

		$this->response['post_time'] = $result['post_time'];

		

		preg_match("/<redirect_url>(.*)<\/redirect_url>/", $result['res'], $Redirect_url);

		preg_match("/<status>(.*)<\/status>/", $result['res'], $Status);	

		preg_match("/<commission>(.*)<\/commission>/", $result['res'], $Amount);	

		

//		print_r($Redirect_url);

//		print_r($Status);

//		print_r($Amount);die;

		$Status[1] = 1;

		$Amount[1] = 10;

		$Redirect_url[1] = 'https://www.google.com/';

		if ($Status[1] == '1') { 

			$this->response['accept'] = 'ACCEPTED';

			$this->response['post_price'] = $Amount[1];

			$this->response['post_status'] = '1';

			$this->response['redirect_url'] = $Redirect_url[1];



		} else {

			$this->response['accept'] = 'REJECTED';

			$this->response['post_status'] = '0';

			$this->response['post_price'] = '0';

		}

//		print_r($this->response);exit;

		return $this->response;



    }

}