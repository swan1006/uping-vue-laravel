<?php
namespace PingYo;

use Illuminate\Support\Facades\Log;

class Status
{

    public $httpcode = "";
    public $errors = "";
    public $correlationid = "";
    public $message = "";
    public $statuscheckurl = "";

    public $percentagecomplete = 0;
    public $redirecturl = "";
    public $status = "";
    public $estimatedcommission = "";

    private $logger = null;

    function __construct(
        $http_code,
        $json_response,
        $correlationid = null,
        \Psr\Log\LoggerInterface $logger = null
    )
    {
//        if (!is_null($logger)) {
//            $this->logger = $logger;
//        }

        if (!is_null($correlationid)) {
            $this->correlationid = $correlationid;
            $this->statuscheckurl = '/application/status/' . $correlationid;
        } else {
            $r = json_decode($json_response);
//            Log::debug($r);
            $this->httpcode = $http_code;
            if (isset($r->Errors)) {
                $this->errors = $r->Errors;
            }
            if (isset($r->CorrelationId)) {
                $this->correlationid = $r->CorrelationId;
            }
            if (isset($r->Message)) {
                $this->message = $r->Message;
            }
            if (isset($r->StatusCheckUrl)) {
                $this->statuscheckurl = $r->StatusCheckUrl;
            }
        }
    }

    public static function CreateFromCorrelationId($correlationid, \Psr\Log\LoggerInterface $logger = null)
    {
        return new Status(null, null, $correlationid, $logger);
    }

    public function refresh()
    {
//        if (!is_null($this->logger)) {
//            $this->logger->debug("Status::refresh()");
//        }
        $ch = curl_init();

        if (!is_null($this->logger)) {
            $this->logger->info("status request sent: http://leads.pingyo.co.uk" . $this->statuscheckurl);
        }

        curl_setopt($ch, CURLOPT_URL, "http://leads.pingyo.co.uk" . $this->statuscheckurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json, text/javascript, *.*',
            'Content-type: application/json; charset=utf-8'
        ));

        $server_output = curl_exec($ch);
        Log::debug('Status Output::', (array) $server_output);

//        if (!is_null($this->logger)) {
//            $this->logger->info('got response: ' . $server_output);
//        }

        $r = json_decode($server_output);
        Log::debug('Status RESP::', (array) $r);

        if (isset($r->PercentageComplete)) {
            $this->percentagecomplete = $r->PercentageComplete;
        }
        if (isset($r->RedirectionUrl)) {
            $this->redirecturl = $r->RedirectionUrl;
        }
        if (isset($r->Message)) {
            $this->message = $r->Message;
        }
        if (isset($r->Status)) {
            $this->status = $r->Status;
        }
        if (isset($r->EstimatedCommission)) {
            $this->estimatedcommission = $r->EstimatedCommission;
        }

        $info = curl_getinfo($ch);
        curl_close($ch);

        return $r;
    }

}
