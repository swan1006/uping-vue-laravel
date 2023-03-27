<?php

namespace App\Models\CheckStatus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckStatusLogger extends Model
{

    /**
     * @var string
     */
    protected $table = 'lms_check_status_loggers';

    use HasFactory;

    var $http_code;
    var $correlationid;
    var $percentagecomplete;
    var $message;


    var $log_id;
    var $lead_id;
    var $country_code;
    var $request;
    var $response;
    var $table_name;

    /**
     * CheckStatusLogger constructor.
     */
    public function __construct()
    {

        parent::__construct();


        $this->http_code = null;
        $this->correlationid = null;
        $this->percentagecomplete = null;
        $this->message = null;

        $this->log_id = null;
        $this->lead_id = null;
        $this->country_code = null;
        $this->request = [
            'client_issued_at' => null,
            'affiliate_received_at' => null,
            'affiliate_issued_at' => null,
            'api_received_at' => null
        ];
        $this->response = [
            'api_issued_at' => null,
            'affiliate_received_at' => null,
            'affiliate_issued_at' => null,
            'client_received_at' => null,
            'progress_percentage' => null
        ];

    }



    /**
     *
     */
    public function add()
    {
        $data = DB::table($this->table)->insert([
            'lead_id' => $this->lead_id,
            'country_code' => $this->country_code,

            'request_client_issued_at' => $this->request['client_issued_at'],
            'request_affiliate_received_at' => $this->request['affiliate_received_at'],
            'request_affiliate_issued_at' => $this->request['affiliate_issued_at'],
            'request_api_received_at' => $this->request['api_received_at'],

            'response_api_issued_at' => $this->response['api_issued_at'],
            'response_affiliate_received_at' => $this->response['affiliate_received_at'],
            'response_affiliate_issued_at' => $this->response['affiliate_issued_at'],
            'response_client_received_at' => $this->response['client_received_at'],

            'response_progress_percentage' => $this->response['progress_percentage']
        ]);
        return DB::table($this->table)->latest()->first();
    }

    /**
     * @param $id
     * @param $prev_response_data
     */
    function updateStatus($id, $prev_response_data) {
        $query = DB::table($this->table)
            ->where('id', $id)
            ->update([
            'response_affiliate_received_at' => $prev_response_data['response_affiliate_received_at'],
            'response_affiliate_issued_at' => $prev_response_data['response_affiliate_issued_at'],
            'response_client_received_at' => $prev_response_data['response_client_received_at'],
        ]);
    }

    /**
     * Show / View
     * @param $lead_id
     * @param $country_code
     * @return mixed
     */
    public function get($lead_id, $country_code) {
        $query = DB::table($this->table)
            ->where('lead_id', $lead_id)
            ->where('country_code', $country_code);
        $res = $query->get()->toArray();
        return $res;
    }
}
