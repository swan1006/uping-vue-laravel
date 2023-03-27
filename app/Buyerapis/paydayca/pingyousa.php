<?php

use App\Helpers\CurlHelper;

class pingyousa
{
    var $response = array();

    function __construct($client_detail = null)
    {
		if($client_detail !== null) {
					$nextPayDate1 = date("c", strtotime($_POST['nextPayDate1']));
					$nextPayDate2 = date("c", strtotime($_POST['nextPayDate2']));
					$dob = date("c", strtotime($_POST['dob']));

//					$cDate = date("Y-m-d", strtotime($_POST['cDate']));

					// Time at address
					$numberOfMonthsAtAddress = floor($_POST['stayYear'] * 12 + $_POST['stayMonth']);
					$date = date("Y-m-d ", strtotime('-' . $numberOfMonthsAtAddress . " months", strtotime($cDate)));
					$AddressMoveIn = date("c", strtotime($date));

					// Time in current employment status
					$numberOfMonthsInCurrentEmploymentStatus = floor($_POST['employmentYear'] * 12 + $_POST['employmentMonth']);
					$date = date("Y-m-d ", strtotime('-' . $numberOfMonthsInCurrentEmploymentStatus . " months", strtotime($cDate)));
					$EmploymentStarted = date("c", strtotime($date));

					// Time at bank
					$numberOfMonthsInBank = floor($_POST['bankYear'] * 12 + $_POST['bankMonth']);
					$date = date("Y-m-d ", strtotime('-' . $numberOfMonthsInBank . " months", strtotime($cDate)));
					$BankAccountOpened = date("c", strtotime($date));

					$url = explode("?", $_POST['url']);
					$final_url = $url[0];

					$address = $_POST['addressStreet1'];

					if($client_detail->mode == 1) {
						$AffiliateId = $client_detail->parameter1;
						$TestOnly = 'false';
						$this->response['header'] = array('Content-type: text/xml; charset=utf-8');
					} else {
						$AffiliateId = 'TOMJ-USA';
						$TestOnly = 'true';
						$this->response['header'] = array('Content-type: text/xml; charset=utf-8','App-Test-Response-Type: LenderMatchFound');
					}

					$campaign = 'DIRECT';
					if(isset($_POST['vid'])) {
						$campaign = 'AFF_ID_' . $_POST['vid'];
					}

					$sub_aff = 'DIRECT';
					if(isset($_POST['sub_aff_id'])) {
						$sub_aff = 'SUB_AFF_ID_' . $_POST['sub_aff_id'];
					}

			//		print_r($_POST);//die;
					$postdata = '<?xml version="1.0" encoding="utf-8"?>
								<ApplicationRequest xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
								<Campaign>'.htmlspecialchars($campaign, ENT_QUOTES).'</Campaign>
								<AffiliateId>'.htmlspecialchars($AffiliateId, ENT_QUOTES).'</AffiliateId>
								<Timeout>'.htmlspecialchars($client_detail->timeout, ENT_QUOTES).'</Timeout>
								<SubAffiliate>'.htmlspecialchars($sub_aff, ENT_QUOTES).'</SubAffiliate>
								<TestOnly>'.htmlspecialchars($TestOnly, ENT_QUOTES).'</TestOnly>
								<SourceDetails>
								<Address>'.htmlspecialchars($_POST['ipaddress'], ENT_QUOTES).'</Address>
								<CreationUrl>'.htmlspecialchars($final_url, ENT_QUOTES).'</CreationUrl>
								<ReferringUrl>'.htmlspecialchars($final_url, ENT_QUOTES).'</ReferringUrl>
								<LanguageCodes>
								<string>en-GB</string>
								</LanguageCodes>
								<ClientUserAgent>'.htmlspecialchars($_POST['browser'], ENT_QUOTES).'</ClientUserAgent>
								</SourceDetails>
								<Application>
								 <Title>'.htmlspecialchars($_POST['nameTitle'], ENT_QUOTES).'</Title>
								 <FirstName>'.htmlspecialchars($_POST['firstName'], ENT_QUOTES).'</FirstName>
								 <LastName>'.htmlspecialchars($_POST['lastName'], ENT_QUOTES).'</LastName>
								 <DateOfBirth>'.htmlspecialchars($dob, ENT_QUOTES).'</DateOfBirth>
								 <Email>'.htmlspecialchars($_POST['email'], ENT_QUOTES).'</Email>
								 <MobilePhoneNumber>'.htmlspecialchars($_POST['cellPhoneNumber'], ENT_QUOTES).'</MobilePhoneNumber>
								 <HomePhoneNumber>'.htmlspecialchars($_POST['phonePhoneNumber'], ENT_QUOTES).'</HomePhoneNumber>
								 <WorkPhoneNumber>'.htmlspecialchars($_POST['workPhoneNumber'], ENT_QUOTES).'</WorkPhoneNumber>
								 <EmployerName>'.htmlspecialchars($_POST['employerName'], ENT_QUOTES).'</EmployerName>
								 <JobTitle>'.htmlspecialchars($_POST['jobTitle'], ENT_QUOTES).'</JobTitle>
								 <EmploymentStarted>'.htmlspecialchars($EmploymentStarted, ENT_QUOTES).'</EmploymentStarted>
								 <IncomeSource>'.htmlspecialchars($_POST['incomeType'], ENT_QUOTES).'</IncomeSource>
								 <PayFrequency>'.htmlspecialchars($_POST['incomeCycle'], ENT_QUOTES).'</PayFrequency>
								 <PayAmount>'.htmlspecialchars($_POST['monthlyIncome'], ENT_QUOTES).'</PayAmount>
								 <IncomePaymentType>'.htmlspecialchars($_POST['IncomePaymentType'], ENT_QUOTES).'</IncomePaymentType>
								 <NextPayDate>'.htmlspecialchars($nextPayDate1, ENT_QUOTES).'</NextPayDate>
								 <FollowingPayDate>'.htmlspecialchars($nextPayDate2, ENT_QUOTES).'</FollowingPayDate>
								 <LoanAmount>'.htmlspecialchars($_POST['loanAmount'], ENT_QUOTES).'</LoanAmount>
								 <Term>'.htmlspecialchars($_POST['loanTerms'], ENT_QUOTES).'</Term>
								 <MilitaryService>'.htmlspecialchars($_POST['InMilitary'], ENT_QUOTES).'</MilitaryService>
								 <NationalIdentityNumber>'.htmlspecialchars($_POST['ssn'], ENT_QUOTES).'</NationalIdentityNumber>
								 <ConsentToCreditSearch>true</ConsentToCreditSearch>
								 <ConsentToMarketingEmails>'.($_POST['agreeCreditCheck']=='1'? 'true' :'false').'</ConsentToMarketingEmails>
								 <ResidentialStatus>'.htmlspecialchars($_POST['monthlyMortgageRent'], ENT_QUOTES).'</ResidentialStatus>
								 <HouseNumber>'.htmlspecialchars($_POST['houseNumber'], ENT_QUOTES).'</HouseNumber>
								 <HouseName></HouseName>
								 <AddressStreet1>'.htmlspecialchars($address, ENT_QUOTES).'</AddressStreet1>
								 <AddressCity>'.htmlspecialchars($_POST['city'], ENT_QUOTES).'</AddressCity>
								 <AddressState>'.htmlspecialchars($_POST['state'], ENT_QUOTES).'</AddressState>
								 <AddressMoveIn>'.htmlspecialchars($AddressMoveIn, ENT_QUOTES).'</AddressMoveIn>
								 <AddressPostcode>'.htmlspecialchars($_POST['zip'], ENT_QUOTES).'</AddressPostcode>
								 <BankName>'.htmlspecialchars($_POST['BankName'], ENT_QUOTES).'</BankName>
								 <BankAccountNumber>'.htmlspecialchars($_POST['bankAccountNumber'], ENT_QUOTES).'</BankAccountNumber>
								 <BankAccountOpened>'.htmlspecialchars($BankAccountOpened, ENT_QUOTES).'</BankAccountOpened>
								 <BankAccountType>'.htmlspecialchars($_POST['BankAccountType'], ENT_QUOTES).'</BankAccountType>
								 <BankRoutingNumber>'.htmlspecialchars($_POST['bankRoutingNumber'], ENT_QUOTES).'</BankRoutingNumber>
								 <MaritalStatus>'.htmlspecialchars($_POST['maritalStatus'], ENT_QUOTES).'</MaritalStatus>
								 <NumberOfDependents>'.htmlspecialchars($_POST['dependants'], ENT_QUOTES).'</NumberOfDependents>
								 <CombinedMonthlyHouseholdIncome>'.((isset($_POST['CombinedMonthlyHouseholdIncome']))?htmlspecialchars($_POST['CombinedMonthlyHouseholdIncome'], ENT_QUOTES):'').'</CombinedMonthlyHouseholdIncome>
								 <DriversLicenseNumber>'.htmlspecialchars($_POST['DriversLicenseNumber'], ENT_QUOTES).'</DriversLicenseNumber>
								 <DriversLicenseState>'.htmlspecialchars($_POST['DriversLicenseState'], ENT_QUOTES).'</DriversLicenseState>

									 <ApplicationExtensions>
									 <ApplicationExtension>
									 <Name>x</Name>
									 <Value>foo</Value>
									 </ApplicationExtension>
									 <ApplicationExtension>
									 <Name>y</Name>
									 <Value>world</Value>
									</ApplicationExtension>
									</ApplicationExtensions>
								</Application>
								</ApplicationRequest>';


					$this->response['post_url'] = ($client_detail->mode == '2') ? $client_detail->post_url_test : $client_detail->post_url_live;
					$this->response['post_data'] = $postdata;
		}

//		print_r($this->response['post_url']);echo '<br/>';
//		print_r($this->response['post_data']);echo '<br/>';die;
//		print_r($this->response);die;
//		$this->response['header'] = '';

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
		//		print_r($result['res']);die;

		$this->response['post_res'] = $result['res'];
		$this->response['post_time'] = $result['post_time'];

		$this->response['accept'] = 'REJECTED';
		$this->response['post_status'] = '0';
		$this->response['post_price'] = '0';
		return $this->response;
		}


		public function check_status($res){

			//echo 'sss';
//			print_r($res);die;

			preg_match("/<CorrelationId>(.*)<\/CorrelationId>/", $res, $CorrelationId);
			preg_match("/<StatusCheckUrl>(.*)<\/StatusCheckUrl>/", $res, $StatusCheckUrl);

			$url = "http://leads.pingyo.co.uk".$StatusCheckUrl[1];
			//echo $url;
			$url_response = file_get_contents($url);//die;
			//echo '13';print_r($url_response);die;

			preg_match("/<PercentageComplete>(.*)<\/PercentageComplete>/", $url_response, $PercentageComplete);
			preg_match("/<Status>(.*)<\/Status>/", $url_response, $Status);
			preg_match("/<Amount>(.*)<\/Amount>/", $url_response, $Amount);
			preg_match("/<RedirectionUrl>(.*)<\/RedirectionUrl>/", $url_response, $RedirectionUrl);



			$this->responses['post_res'] = $url_response;

			//$Amount[1] = 25;
			//$Status[1] = 'LenderMatchFound';

			if ($Status[1] == 'LenderMatchFound') {
				$this->responses['accept'] = 'ACCEPTED';
				$this->responses['post_price'] = $Amount[1];
				$this->responses['post_status'] = '1';
				$this->responses['redirect_url'] = $RedirectionUrl[1];
				$this->responses['percentage'] = $PercentageComplete[1];
				$this->responses['status'] = $Status[1];

			} else if($Status[1] == 'ConditionalLenderMatchFound') {
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
