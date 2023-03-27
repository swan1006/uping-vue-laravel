<?php
use App\Helpers\CurlHelper;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class uping
{
    var $response = array();
    //function __construct($client_detail, $post){
    //parent::__construct();

    function __construct($client_detail, $post)
    {

        $this->manageDependencies();
        unset($root, $library, $path);

        $dob_day = $post->dateOfBirthDay;
        $dob_month = $post->dateOfBirthMonth;
        $dob_year = $post->dateOfBirthYear;
        $dateOfBirth = $dob_year . '-' . $dob_month . '-' . $dob_day;

        $next_pay_date_day = $post->nextPayDateDay;
        $next_pay_date_month = $post->nextPayDateMonth;
        $next_pay_date_year = $post->nextPayDateYear;
        $nextPayDate = $next_pay_date_year . '-' . $next_pay_date_month . '-' . $next_pay_date_day;

        $followingPayDateDay = $post->followingPayDateDay;
        $followingPayDateMonth = $post->followingPayDateMonth;
        $followingPayDateYear = $post->followingPayDateYear;
        $followingPayDate = $followingPayDateYear . '-' . $followingPayDateMonth . '-' . $followingPayDateDay;

        $AddressMoveIn = floor($post->stayYear * 12 + $post->monthsAtAddress);
//        dd($AddressMoveIn);

        $ssn = str_replace('-', '', $post->ssn);

        // Time in current data->employment status
        $EmploymentStarted = floor($post->monthsAtEmployer);

        // Time at bank
        $BankAccountOpened = floor($post->bankAccountLength);

        $country = 'USA';
        $bestTimeToCall = 'Other';
        $monthsAtEmployer = $post->employer->monthsAtEmployer;
        $next_pay_date_day = $post->employer->nextPayDateDay;
        $next_pay_date_month = $post->employer->nextPayDateMonth;
        $next_pay_date_year = $post->employer->nextPayDateYear;


        if ($post->istest === '1') {
            $post->istest = true;
        } else {
            $post->istest = false;
        }

        if (!isset($post->timeout)) {
            $client_detail->timeout = $post->timeout;
        }

//        dd($post);

        $application = new \UPing\Application();
        $application->vid = $client_detail->parameter1;
        $application->timeout = $post->timeout ?? $client_detail->timeout;
        $application->istest = $client_detail->mode;
        $application->vid = $post->vid;
        $application->oid = $post->oid;
        $application->istest = true;
        $application->subid = $post->subid;
        $application->minComissionAmount = '';
        $application->maxComissionAmount = '';
        $application->response_type = 'json';
//        $application->tier = '';
//        $application->response_type = 'json';

        $application->source = new \UPing\Source();
        $application->source->ipAddress = $post->source->ipAddress;
        $application->source->creationUrl = $post->source->creationUrl;
        $application->source->referringUrl = $post->source->referringUrl;
        $application->source->userAgent = $post->source->userAgent;

        $application->loan = new \UPing\Loan();
        $application->loan->loanAmount = $post->loan->loanAmount;
        $application->loan->loanPurpose = $post->loan->loanPurpose;
        $application->loan->loanTerms = $post->loan->loanTerms;

        $application->applicant = new \UPing\Applicant();
        $application->applicant->firstName = $post->applicant->firstName;
        $application->applicant->lastName = $post->applicant->lastName;
        $application->applicant->drivingLicenseNumber = $post->applicant->drivingLicenseNumber;
        $application->applicant->drivingLicenseState = $post->applicant->drivingLicenseState;
        $application->applicant->ssn = $post->applicant->ssn;;
        $application->applicant->dateOfBirthDay = $post->applicant->dateOfBirthDay;
        $application->applicant->dateOfBirthMonth = $post->applicant->dateOfBirthMonth;
        $application->applicant->dateOfBirthYear = $post->applicant->dateOfBirthYear;
        $application->applicant->email = $post->applicant->email;
//        dd($post->applicant->homePhoneNumber);
        $application->applicant->homePhoneNumber = $post->applicant->homePhoneNumber;
        $application->applicant->cellPhoneNumber = $post->applicant->cellPhoneNumber;
        $application->applicant->workPhoneNumber = $post->applicant->workPhoneNumber;
        $application->applicant->inMilitary = $post->applicant->inMilitary;

        $application->residence = new \UPing\Residence();
        $application->residence->state = $post->residence->state;
        $application->residence->city = $post->residence->city;
        $application->residence->zip = $post->residence->zip;
        $application->residence->addressStreet1 = $post->residence->addressStreet1;
        $application->residence->residentialStatus = $post->residence->residentialStatus;
        $application->residence->monthsAtAddress = $post->residence->monthsAtAddress;

        $application->employer = new \UPing\Employer();
        $application->employer->employerName = $post->employer->employerName;
        $application->employer->jobTitle = $post->employer->jobTitle;
        $application->employer->incomeSource = $post->employer->incomeSource;
        $application->employer->monthlyIncome = $post->employer->monthlyIncome;
        $application->employer->monthsAtEmployer = $post->employer->monthsAtEmployer;
        $application->employer->nextPayDateDay = $post->employer->nextPayDateDay;
        $application->employer->nextPayDateMonth = $post->employer->nextPayDateMonth;
        $application->employer->nextPayDateYear = $post->employer->nextPayDateYear;
        $application->employer->followingPayDateDay = $post->employer->followingPayDateDay;
        $application->employer->followingPayDateMonth = $post->employer->followingPayDateMonth;
        $application->employer->followingPayDateYear = $post->employer->followingPayDateYear;
        $application->employer->incomeCycle = $post->employer->incomeCycle;
        $application->employer->incomePaymentType = $post->employer->incomePaymentType;

        $application->bank = new \UPing\Bank();
        $application->bank->bankName = $post->bank->bankName;
        $application->bank->bankAccountLength = $post->bank->bankAccountLength;
        $application->bank->bankRoutingNumber = $post->bank->bankRoutingNumber;
        $application->bank->bankAccountNumber = $post->bank->bankAccountNumber;
        $application->bank->bankAccountType = $post->bank->bankAccountType;

        $application->consent = new \UPing\Consent();
        $application->consent->consentFinancial = $post->consent->consentFinancial;
        $application->consent->consentThirdPartyEmails = $post->consent->consentThirdPartyEmails;
        $application->consent->consentThirdPartyPhone = $post->consent->consentThirdPartyPhone;
        $application->consent->consentThirdPartySMS = $post->consent->consentThirdPartySMS;


//        $application->setApplicationDetails($application);
        $application->setSourceDetails($application->source);
        $application->setLoanDetails($application->loan);
        $application->setApplicantDetails($application->applicant);
        $application->setEmployerDetails($application->employer);
        $application->setResidenceDetails($application->residence);
        $application->setBankDetails($application->bank);
        $application->setConsentDetails($application->consent);



        $validation_result = $application->validate();
//        $validation_result = true;
//        dd($validation_result);
        if ($validation_result == true) {
//        dd(json_encode($application));
            $application_status = $application->send($application);
//            dd($application_status);
            $this->response['application_response'] = (array)$application_status;
            $this->response['validated'] = true;
            $this->response['post_url'] = ($client_detail->status == '0') ? $client_detail->post_url_test : $client_detail->post_url_live;
        } else {
            $this->response['application_response'] = $validation_result;
            $this->response['validated'] = false;
        }


//        $this->response['post_url'] = ($client_detail->status === 0) ? $client_detail->post_url_test : $client_detail->post_url_live;
//        $this->response['post_data'] = json_encode($application);
//        $this->response['header'] = [
//            'Authorization: Bearer 1|mJwzwA1pUUOhvfYrchYqsuf9hGatl2Lc1OKJTLPH',
//            'Accept: application/json, text/javascript, *.*',
//            'Content-type: application/json; charset=utf-8',
//            'Expect:'
//        ];
//        $this->response['tier_price'] = $client_detail->tier_price;


//        dd($this->response);
    }
    private function manageDependencies()
    {
        require_once dirname(__DIR__) . '/vendor/UPing/Application.php';
        require_once dirname(__DIR__) . '/vendor/UPing/Source.php';
        require_once dirname(__DIR__) . '/vendor/UPing/Loan.php';
        require_once dirname(__DIR__) . '/vendor/UPing/Applicant.php';
        require_once dirname(__DIR__) . '/vendor/UPing/Employer.php';
        require_once dirname(__DIR__) . '/vendor/UPing/Residence.php';
        require_once dirname(__DIR__) . '/vendor/UPing/Bank.php';
        require_once dirname(__DIR__) . '/vendor/UPing/Consent.php';
        require_once dirname(__DIR__) . '/vendor/autoload.php';
        require_once dirname(__DIR__) . '/vendor/UPing/Status.php';
        require_once dirname(__DIR__) . '/vendor/UPing/ExtendedValidator.php';

    }

    public function returnresponse()
    {
        $this->response['validated'] = true;

        $appResponse = $this->response['application_response'];
        if ($this->response['validated'] === true) {
            $status = new UPing\Status('202', null, $appResponse['correlationid'], null);
//            dd($status);
            $counter = 0;
            while (true) {
                $res = $status->refresh();
                $counter++;
                if ($status->percentagecomplete == 100) {
                    break;
                }
                if ($status->status == 'Accepted') {
                    break;
                }

                sleep(3);
            }



            $this->response['post_res'] = json_encode($status);

            $this->response['correlationid'] = $status->correlationid;
//        preg_match("/<Payout>(.*)<\/Payout>/", $this->response['post_res'], $price);
//        preg_match("/<Result>(.*)<\/Result>/", $this->response['post_res'], $status);
//        preg_match("/<RedirectURL>(.*)<\/RedirectURL>/", $this->response['post_res'], $RedirectURL);

            //print_r($price); print_r($status);exit;

            if ($status->status == 'Accepted') {
                $this->response['accept'] = 'ACCEPTED';
                $this->response['post_price'] = $status->estimatedcommission;
                $this->response['post_status'] = '1';
                $this->response['redirect_url'] = $status->redirecturl;

            } else {
                $this->response['accept'] = 'REJECTED';
                $this->response['post_status'] = '0';
                $this->response['post_price'] = '0';
            }
            //print_r($this->response);exit;
            return $this->response;
        } else {
            $this->response['accept'] = 'Validation Failed';
            $this->response['post_status'] = '0';
            $this->response['post_price'] = '0';
            return $this->response;
        }

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
