<?php

use App\Helpers\CurlHelper;
use Illuminate\Support\Str;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class freshwaymedia
{
    var $response = array();
    //function __construct($client_detail, $post){
    //parent::__construct();
    function get_client_ip($ip)
    {
        $ipaddress = $ip;
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

    function dd($parm = null)
    {
        echo '<pre>';
        print_r($parm);
        exit;

    }

    function __construct($client_detail, $post)
    {
        $dob_day = $post->applicant->dateOfBirthDay;
        $dob_month = $post->applicant->dateOfBirthMonth;
        $dob_year = $post->applicant->dateOfBirthYear;
        $dateOfBirth = $dob_year . '-' . $dob_month . '-' . $dob_day;

        $next_pay_date_day = $post->employer->nextPayDateDay;
        $next_pay_date_month = $post->employer->nextPayDateMonth;
        $next_pay_date_year = $post->employer->nextPayDateYear;
        $nextPayDate = $next_pay_date_year . '-' . $next_pay_date_month . '-' . $next_pay_date_day;

        $followingPayDateDay = $post->employer->followingPayDateDay;
        $followingPayDateMonth = $post->employer->followingPayDateMonth;
        $followingPayDateYear = $post->employer->followingPayDateYear;
        $followingPayDate = $followingPayDateYear . '-' . $followingPayDateMonth . '-' . $followingPayDateDay;

        $AddressMoveIn = floor($post->residence->monthsAtAddress);

        // Time in current employment status
        $EmploymentStarted = floor($post->employer->monthsAtEmployer);

        $monthsAtBank = floor($post->bank->bankAccountLength);


        switch ($post->nameTitle) {
            case 'Mr':
                $post->applicant->nameTitle = '1';
            case 'Mrs':
                $post->applicant->nameTitle = '2';
            case 'Ms':
                $post->applicant->nameTitle = '3';
            case 'Miss':
                $post->applicant->nameTitle = '4';
        }
        switch ($post->incomeSource) {
            case 'SelfEmployed':
                $post->employer->incomeSource = 'self_employed';
            case 'EmployedFullTime':
                $post->employer->incomeSource = 'employment';
            case 'EmployedPartTime':
                $post->employer->incomeSource = 'employment';
            case 'EmployedTemporary':
                $post->employer->incomeSource = 'employment';
            case 'Pension':
                $post->employer->incomeSource = 'employment';
            case 'DisabilityBenefits':
                $post->employer->incomeSource = 'benefits';
            case 'Benefits':
                $post->employer->incomeSource = 'benefits';
        }
        switch ($post->incomeCycle) {
            case 'Weekly':
                $post->employer->incomeCycle = 'weekly';
            case 'BiWeekly':
                $post->employer->incomeCycle = 'bi_weekly';
            case 'TwiceMonthly':
                $post->employer->incomeCycle = 'twice_monthly';
            case 'FourWeekly':
                $post->employer->incomeCycle = 'monthly';
            case 'Monthly':
                $post->employer->incomeCycle = 'monthly';
        }
        switch ($post->incomePaymentType) {
            case 'Cash':
                $post->employer->incomePaymentType = 'false';
            case 'Cheque':
                $post->employer->incomePaymentType = 'false';
            case 'RegionalDirectDeposit':
                $post->employer->incomePaymentType = 'true';
        }
        switch ($post->applicant->inMilitary) {
            case 'None':
                $post->applicant->inMilitary = '0';
            case 'Veteran':
                $post->applicant->inMilitary = '1';
            case 'Reserves':
                $post->applicant->inMilitary = '1';
            case 'ActiveDuty':
                $post->applicant->inMilitary = '1';
        }
        switch ($post->residence->residentialStatus) {
            case 'HomeOwner':
                $post->residence->residentialStatus = 'own';
            case 'PrivateTenant':
                $post->residence->residentialStatus = 'rent';
            case 'CouncilTenant':
                $post->residence->residentialStatus = 'rent';
            case 'LivingWithParents':
                $post->residence->residentialStatus = 'rent';
            case 'LivingWithFriends':
                $post->residence->residentialStatus = 'rent';
            case 'Other':
                $post->residence->residentialStatus = 'rent';

        }
        switch ($post->applicant->maritalStatus) {
            case 'Single':
                $post->applicant->maritalStatus = '1';
            case 'Married':
                $post->applicant->maritalStatus = '2';
            case 'LivingTogether':
                $post->applicant->maritalStatus = '3';
            case 'Separated':
                $post->applicant->maritalStatus = '4';
            case 'Divorced':
                $post->applicant->maritalStatus = '5';
            case 'Widowed':
                $post->applicant->maritalStatus = '6';
            case 'Other':
                $post->applicant->maritalStatus = '7';

        }
        switch ($post->bank->bankAccountType) {
            case 'Checking':
                $post->bank->bankAccountType = 'checkings';
            case 'Savings':
                $post->bank->bankAccountType = 'savings';

        }


        $application = (object)[];
//        $application->time_allowed = $client_detail->timeout;
        $application->affiliateId = $client_detail->parameter1;
//        $application->partner_password = $client_detail->parameter2;

        $application->ipAddress = $post->source->ipAddress;
        $application->userAgent = $post->source->userAgent;
        $application->referrerUrl = $post->source->referringUrl;

        $application->affiliateSubId = $post->subid;
        $application->firstName = $post->applicant->firstName;
        $application->lastName = $post->applicant->lastName;
        $application->email = $post->applicant->email;
        $application->dateOfBirth = $dateOfBirth;

        $application->address = $post->residence->addressStreet1;
        $application->city = $post->residence->city;
        $application->state = $post->residence->state;
        $application->zipCode = $post->residence->zip;
        $application->country = 'USA';

        $application->homePhone = $post->applicant->homePhoneNumber;
        $application->cellPhone = $post->applicant->cellPhoneNumber;
        $application->workPhone = $post->applicant->workPhoneNumber;

        $application->residenceType = $post->residence->residentialStatus;
        $application->monthlyNetIncome = $post->employer->monthlyIncome;

        $application->payFrequency = $post->employer->incomeCycle;
        $application->paydate1 = $nextPayDate;
        $application->paydate2 = $followingPayDate;

        $application->monthsAtResidence = $AddressMoveIn;

        $application->loanAmount = $post->loan->loanAmount;
        $application->incomeSource = $post->employer->incomeSource;
        $application->isMilitary = $post->applicant->inMilitary;
        $application->employmentPosition = $post->employer->jobTitle;
        $application->employerName = $post->employer->employerName;
        $application->monthsEmployed = $EmploymentStarted;

        $application->bankName = $post->bank->bankName;
        $application->accountType = $post->bank->bankAccountType;
        $application->bankAccount = $post->bank->bankAccountNumber;
        $application->abaRouting = $post->bank->bankRoutingNumber;
        $application->monthsAtBank = $monthsAtBank;
        $application->directDeposit = $post->bank->incomePaymentType;

        $application->driverLicenseState = $post->applicant->drivingLicenseState;
        $application->driverLicense = $post->applicant->drivingLicenseNumber;
        $application->ssn = $post->applicant->ssn;
        $application->bestTimeToCall = $post->bestTimeToCall;

        dd($application);

        $this->response['post_url'] = ($client_detail->mode == '2') ? $client_detail->post_url_test : $client_detail->post_url_live;
//        $this->response['post_url'] = $this->response['post_url'];
        $this->response['post_data'] = http_build_query($application);
        $this->response['header'] = array();
        $this->response['timeout'] = $client_detail->timeout;

//        dd($this->response);

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

        dd(json_decode($this->response['post_res']));
        return $this->response;
    }

    public function returnresponse_ping($result)
    {
        //print_r($result);exit;
        $this->response['ping_res'] = html_entity_decode($result['ping_res']);

        $this->response['ping_time'] = $result['ping_time'];
        //echo $this->response['ping_time'];exit;
        preg_match("/<Payout>(.*)<\/Payout>/", $this->response['ping_res'], $price);
        preg_match("/<Result>(.*)<\/Result>/", $this->response['ping_res'], $status);
        preg_match("/<LeadID>(.*)<\/LeadID>/", $this->response['ping_res'], $pingid);

        if ($status[1] == 'Accepted') {
            $this->response['accept'] = 'ACCEPTED';
            $this->response['ping_price'] = $price[1];
            $this->response['ping_status'] = '1';
        } else {
            $this->response['accept'] = 'REJECTED';
            $this->response['ping_status'] = '0';
            $this->response['ping_price'] = '0';
        }
        return $this->response;
    }

}
