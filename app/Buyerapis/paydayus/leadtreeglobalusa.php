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
            "AffiliateAPIKey" => "4dd3204d-a01d-452d-ae48-8d8c86343000",
            "affiliateReference" => "test",
            "affiliateSubReference" => "",
            "affiliateCampaign" => "10",

            "referringUrl" => (string)$post->source->referringUrl,
            "userAgent" => (string)$post->source->userAgent,
            "ipAddress" => (string)$post->source->ipAddress,

            "salutation" => (int) $post->applicant->nameTitle ?? 1,
            "firstName" => (string)$post->applicant->firstName,
            "surname" => (string)$post->applicant->lastName,
            "emailAddress" => (string)$post->applicant->email,
            "dateOfBirthDay" => (string)$post->applicant->dateOfBirthDay,
            "dateOfBirthMonth" => (string)$post->applicant->dateOfBirthMonth,
            "dateOfBirthYear" => (string)$post->applicant->dateOfBirthYear,
            "maritalStatus" => (string)$post->applicant->maritalStatus,
            "cellPhoneNumber" => (string)$post->applicant->mobilePhoneNumber,
            "homePhoneNumber" => (string)$post->applicant->homePhoneNumber,
            "workPhoneNumber" => (string)$post->applicant->homePhoneNumber,
            "residentialStatus" => (int)$post->residence->residentialStatus,

            "consentToCreditSearch" => (bool)$post->consent->consentCreditSearch,
            "consentToMarketingEmails" => (bool)$post->consent->consentToMarketingEmails,
            "consentToMarketingSMS" => (bool)$post->consent->consentToMarketingSMS,

            "abaRoutingTransitNumber" => (string)$post->bank->bankRoutingNumber,
            "bankAccountNumber" => (string)$post->bank->bankAccountNumber,
//            "bankCardType" => (string)$post->bank->bankAccountNumber,

            "houseNumber" => (string)$post->residence->houseNumber,
            "street1" =>  (string)$post->residence->addressStreet1,
            "townCity" =>  (string)$post->residence->city,
            "state" =>  (string)$post->residence->state,
            "zipCode" =>  (string)$post->residence->zip,
            "monthsAtAddress" =>  (string)$post->residence->monthsAtAddress,

            "loanAmount" => (int)$post->loan->loanAmount,
            "employmentStatus" => (int)$post->employer->employmentStatus,
            "employerName" => (int)$post->employer->employerName,
            "income" => (int)$post->employer->monthlyIncome,
            "incomeFrequency" => (int)$post->employer->incomeCycle,
            "nextPayDateDay" => (int)$post->employer->nextPayDateDay,
            "nextPayDateMonth" => (int)$post->employer->nextPayDateMonth,
            "nextPayDateYear" => (int)$post->employer->nextPayDateYear,
            "followingPayDateDay" => (int)$post->employer->nextPayDateYear,
            "followingPayDateMonth" => (int)$post->employer->followingPayDateMonth,
            "followingPayDateYear" => (int)$post->employer->followingPayDateYear,

//            "MonthsWithEmployer" => (int)$post->employer->incomeSource,

            "drivingLicenseIssuingState" => (string) $post->applicant->drivingLicenseState,
            "drivingLicenseNumber" => (string) $post->applicant->drivingLicenseNumber,
            "socialSecurityNumber" => (int) $post->applicant->ssn,

            "bankName" => (int) $post->bank->bankName,
            "bankAccountType" => (int) $post->bank->bankAccountType,
            "monthsWithBank" =>  (string) $BankAccountOpened,
            "jobTitle" => (int)$post->employer->incomeSource,
            "consentToTerms" => (boolean) $post->consent->consentFinancial
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
