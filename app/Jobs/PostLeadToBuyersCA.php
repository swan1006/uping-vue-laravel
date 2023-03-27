<?php

namespace App\Jobs;

use App\Buyersetup;
use App\Http\Controllers\LeadTestController;
use App\Http\Controllers\LeadTestControllerCA;
use App\Lmscallcenter;
use App\Models\BuyerFilterCA;
use App\Models\LmsPaydayCA;
use App\Offer;
use App\Pubbuyermapping;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PostLeadToBuyersCA implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    var string $leadtype = 'paydayca';

    private $post;
    private $inputs;
    private $partner_detail;
    private $partnerlogid;
    private $data;
    private $status_check;
    private $buyer_status;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post, $inputs, $partnerDetail, $partnerlogid, $data, $status_check)
    {
        $this->post = $post;
        $this->inputs = $inputs;
        $this->partner_detail = $partnerDetail;
        $this->partnerlogid = $partnerlogid;
        $this->data = $data;
        $this->status_check = $status_check;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $startTime = explode(' ', microtime());
        $startTime = $startTime[1] + $startTime[0];
        $post = $this->post;
        $inputs = $this->inputs;
        $data = $this->data;
        $partnerlogid = $this->partnerlogid;


        Log::debug('Posting to buyer');
        $res = $this->BuyerPost($post);
        Log::debug('DEBUG::', $res);

        // Parse buyer response
        if (!is_null($res) && $res['leadStatus'] == "1") {
            $offer_detail = Offer::get($inputs['oid']);

            $res = array(
                'status' => 1,
                'price' => $res['price'],
                'leadid' => $res['id'],
            );
//            dd($res);

            $thresholdAmount = $offer_detail[0]['payout']['payoutAmount'];
            $offer_id = $offer_detail[0]['id'];

            // Separate threshold amount for VID 87 and OID
//            if ($data['vid'] == 87 && $offer_id == 7) {
//                $thresholdAmount = 10;
//            }

            if ($thresholdAmount > 0 && ($offer_id == 6 || $offer_id === 9 )) {
                if ($offer_id === 6) {
                    $accumulatorAmount = 0 + $this->partner_detail->accuCPAus100; // use US accu db
                } elseif ($offer_id === 9) {
                    $accumulatorAmount = 0 + $this->partner_detail->accuCPLus20;
                }
                $accumulatorAmount = $accumulatorAmount + $res['price'];
                $res['ThresholdAmount'] = $thresholdAmount;

                if ($accumulatorAmount >= $thresholdAmount) {
                    $accumulatorAmount = $accumulatorAmount - $thresholdAmount;
                    $res['Threshold'] = 'true';
                } else {
                    $res['Threshold'] = 'false';
                }
                if ($offer_id === 6) {
                    $lead_data = array(
                        'id' => $this->partner_detail->id,
                        'accuCPAus100' => $accumulatorAmount
                    );
                } elseif ($offer_id === 9) {
                    $lead_data = array(
                        'id' => $this->partner_detail->id,
                        'accuCPLus20' => $accumulatorAmount
                    );
                }

                $response = (new Lmscallcenter)->AddLeadType($lead_data);
            }

//            dd($this->partner_detail->currencyType);
            if (!empty($this->partner_detail) && $this->partner_detail->currencyType != 'USD') {
                $rate = LmsPaydayCA::GetDailyRate();
                $res['price'] = $res['price'] * $rate['usd'];
            }
        } else {
            try {
                $oldRes = $res;
                $res = array(
                    'status' => 2,
                    'leadid' => $res['id']
                );
                $res['errors'] = $oldRes ['errors'];
            } catch (\Exception $e) {
                // ignore
            }
        }


        Log::debug('Response array: ' . json_encode($res));

//        // Generate Check status ID
//        $CheckStatusLogger = new CheckStatusLogger;
//        $CheckStatusLogger->lead_id = $post['leadid'];
//
//        $CheckStatusLogger->country_code = 'uk';
//        $CheckStatusLogger->response['api_issued_at'] = Carbon::now()->timestamp;
//        $CheckStatusLogger->response['progress_percentage'] = 'STARTED';
//        // Commented below code as we are not getting request_client_issue_at and others
////        $CheckStatusLogger->request = [
////            'client_issued_at' => $inputs['request_client_issued_at'],
////            'affiliate_received_at' => $inputs['request_affiliate_received_at'],
////            'affiliate_issued_at' => $inputs['request_affiliate_issued_at'],
////            'api_received_at' => Carbon::now()->timestamp
////        ];
//
//        $check_status = $CheckStatusLogger->add();
//        $res['check_status_id'] = DB::table('lms_check_status_loggers')->orderBy('id', 'desc')->first()->id;
//        $res['check_status'] = $check_status->response_progress_percentage;

        $logs = LmsPaydayCA::getlog($res["leadid"]);

        if (count($logs) > 0) {
            $log = $logs[0];
//            $CheckStatusLogger->correlation_id();
            if ($log->buyer_id === 1 || $log->buyer_id === 2) {
                $res["check_status"] = true;
            } else {
                $res['check_status'] = false;
            }
        }

        $post_response = $this->curl_response_post($res);
        Log::debug('Response XML: ' . $post_response);


        $etime = explode(' ', microtime());
        $etime = $etime[1] + $etime[0];
        $post_time = $etime - $startTime;

        $data = array(
            'id' => $partnerlogid,
            'leadid' => $post->leadid,
            'post_response' => $post_response,
            'post_status' => $res['status'],
            'post_time' => $post_time);

        $res = LmsPaydayCA::update_log_partner($data);

        // response is ready to return, marking job as completed.
        $this->status_check->resp  = $post_response;
        $this->status_check->percentage = 100;
        $this->status_check->status  = 'completed';
        $this->status_check->save();
//        echo $post_response;
//        exit;
    }


    /**
     *  This function checks active buyers for enabled filters
     *  if so, the lead is filtered against the buyer filters.
     *
     * @param $post
     * @return array
     */
    public function BuyerPost($post)
    {
        $post = BuyerFilterCA::allBuyerFilters($post);
        $post->subid = 'DIRECT';


        if ($post->istest == 1) {
            $testBuyer = (new LeadTestControllerCA)->getTestBuyer();

            $buyer_list['row'] = $testBuyer;

            Log::debug('DEBUG::', $buyer_list['row']);


            if (is_array($buyer_list['row']) && !empty($buyer_list['row'])) {
                $index = 0;
                $length = count($buyer_list['row']);


                foreach ($buyer_list['row'] as $key => $value) {
                    $row = (object)$value;
                    $row = $this->GetBuyerObject($row);
//                    Log::debug($row->company);

                    $filename = app_path("Buyerapis/" . $this->leadtype . '/' . strtolower($row->company) . ".php");

//                    Log::debug($filename);

                    if (file_exists($filename)) {
                        require_once($filename);

                        $classname = strtolower($row->company);
                        $obj = new $classname($row, $post);
//                        Log::debug('DEBUG::' (array($post)));


                        $lender_response = $obj->returnresponse();
                        Log::debug($lender_response);

                        $datalogo = array(
                            'leadid' => $post->id,
                            'vid' => $post->vid,
                            'buyer_id' => $row->buyer_id,
                            'buyersetup_id' => $row->id,
                            'post_price' => $lender_response['post_price'] ?? "",
                            'post_url' => $lender_response['post_url'] ?? "",
                            'post_data' => trim(preg_replace('/\s+/', ' ', $lender_response['post_data'] ?? "")),
                            'post_response' => trim(preg_replace('/\s+/', ' ', $lender_response['post_res'] ?? "")),
                            'post_status' => $lender_response['post_status'] ?? "",
                            'post_time' => $lender_response['post_time'] ?? "Unavailable",
                            'lender_found' => $lender_response['LenderFound'] ?? "",
                            'created_at' => date('Y-m-d H:i:s')
                        );
                        $res = LmsPaydayCA::AddLog($datalogo);
                        Log::debug($lender_response);


                        if (isset($lender_response['post_price']) && isset($lender_response['accept']) && $lender_response['accept'] == 'ACCEPTED') {
                            if (!empty($this->partner_detail->margin)) {
                                if ($post->tier == 'all') {
                                    $price =
                                        $lender_response['post_price'] - ($lender_response['post_price'] * ($this->partner_detail->margin / 100));
                                } else {
                                    $price =
                                        $lender_response['post_price'] - ($lender_response['post_price'] * ($this->partner_detail->margin / 100));
                                }
                            } else {
                                $price = $lender_response['post_price'];

                            }

                            $data = array(
                                'buyerLeadPrice' => $lender_response['post_price'],
                                'vidLeadPrice' => $price,
                                'buyerid' => $row->buyer_id,
                                'buyerTierID' => $row->id,
                                'redirectUrl' => $lender_response['redirect_url'] ?? "",
                                'leadStatus' => '1',
                                'id' => $post->id
                            );
                            $resp = (new LmsPaydayCA)->add($data);


                            $data = array(
                                'price' => $price,
                                'leadStatus' => '1',
                                'id' => $post->id
                            );

                            return $data;


                        } else {
                            $res = (new LmsPaydayCA)->add(
                                array(
                                    'leadStatus' => '2',
                                    'id' => $post->id
                                ));
//
                            $data = array(
                                'id' => $post->leadid,
                                'leadStatus' => '2'
                            );

                            try {
                                $data['errors'] = $lender_response['errors'] ?? "";
                            } catch (Exception $e) {
                                Log::debug($e);
                                // ignore
                            }
                            $index++;
                            if ($index >= $length) {
                                $this->status_check->percentage = 100;
                                $this->status_check->save();
                                Log::debug($this->status_check);
                                return $data;
                            } else {
                                $this->status_check->percentage = (($index) / $length) * 100;
                                $this->status_check->save();
                                continue;
                            }
                        }
                    } else {
                        Log::debug('Buyer file not found: ' . $filename);
                    }
                }
            } else {
                Log::debug('No Buyer found');
            }
        } else {

            $buyer_list['row'] = $post->buyer_list;
//        Log::debug($buyer_list);

            // Checks for credit/lead limits on the buyer tier IDs.
//        $buyer_detail = (new Lmsbuyerleadtype)->buyer_limits($buyer_list['row']);

            if (is_array($buyer_list['row']) && !empty($buyer_list['row'])) {
                $index = 0;
                $length = count($buyer_list['row']);


                foreach ($buyer_list['row'] as $key => $value) {
                    $row = (object)$value;
                    $row = $this->GetBuyerObject($row);

                    $filename = app_path("Buyerapis/" . $this->leadtype . '/' . strtolower($row->company) . ".php");

                    if (file_exists($filename)) {
                        require_once($filename);

                        $classname = strtolower($row->company);
                        $obj = new $classname($row, $post);

                        $lender_response = $obj->returnresponse();

//                        dd($lender_response);

                        $datalogo = array(
                            'leadid' => $post->id,
                            'vid' => $post->vid,
                            'buyer_id' => $row->buyer_id,
                            'buyersetup_id' => $row->buyersetup_id,
                            'post_price' => $lender_response['post_price'] ?? "",
                            'post_url' => $lender_response['post_url'] ?? "",
                            'post_data' => trim(preg_replace('/\s+/', ' ', $lender_response['post_data'] ?? "")),
                            'post_response' => trim(preg_replace('/\s+/', ' ', $lender_response['post_res'] ?? "")),
                            'post_status' => $lender_response['post_status'] ?? "",
                            'post_time' => $lender_response['post_time'] ?? "",
                            'lender_found' => $lender_response['LenderFound'] ?? "",
                            'created_at' => date('Y-m-d H:i:s')
                        );
                        $res = LmsPaydayCA::AddLog($datalogo);


                        if (isset($lender_response['post_price']) && isset($lender_response['accept']) && $lender_response['accept'] == 'ACCEPTED') {
                            if (!empty($this->partner_detail->margin)) {
                                if ($post->tier == 'all') {
                                    $price =
                                        $lender_response['post_price'] - ($lender_response['post_price'] * ($this->partner_detail->margin / 100));
                                } else {
                                    $price =
                                        $lender_response['post_price'] - ($lender_response['post_price'] * ($this->partner_detail->margin / 100));
                                }
                            } else {
                                $price = $lender_response['post_price'];

                            }

                            $data = array(
                                'buyerLeadPrice' => $lender_response['post_price'],
                                'vidLeadPrice' => $price,
                                'buyerid' => $row->buyer_id,
                                'buyerTierID' => $row->buyersetup_id,
                                'redirectUrl' => $lender_response['redirect_url'] ?? "",
                                'leadStatus' => '1',
                                'id' => $post->id
                            );
                            $resp = (new LmsPaydayCA)->add($data);


                            $data = array(
                                'price' => $price,
                                'leadStatus' => '1',
                                'id' => $post->id
                            );

                            return $data;


                        } else {
                            $res = (new LmsPaydayCA)->add(
                                array(
                                    'leadStatus' => '2',
                                    'id' => $post->id
                                ));
//
                            $data = array(
                                'id' => $post->leadid,
                                'leadStatus' => '2'
                            );

                            try {
                                $data['errors'] = $lender_response['errors'] ?? "";
                            } catch (Exception $e) {
                                // ignore
                            }
                            $index++;
                            if ($index >= $length) {
                                $this->status_check->percentage = 100;
                                $this->status_check->save();
                                return $data;
                            } else {
                                $this->status_check->percentage = (($index) / $length) * 100;
                                $this->status_check->save();
                                continue;
                            }
                        }
                    } else {
                        Log::debug('Buyer file not found: ' . $filename);
                    }
                }
            } else {
                Log::debug('No Buyer found');
            }
        }
    }

    /**
     * Return Curl Response in XML.
     *
     * @param $client_response
     * @return string
     */
    function curl_response_post($client_response)
    {

        header("Content-type: text/xml; charset=utf-8");
        $res = '<?xml version="1.0"?>';
        $res .= '<PostResponse>';
        $res .= ($client_response['status'] == '1') ? '<Response>Accepted</Response>' : '<Response>Rejected</Response>';

//        $res .= ($client_response['status'] == '1') ? '<Leadid>' . $client_response['leadid'] . '</Leadid>' : '<Leadid>' . $client_response['leadid'] . '</Leadid>';
        $res .= ($client_response['status'] == '1') ? '<Price>' . $client_response['price'] . '</Price>' : '';
        $res .= ($client_response['status'] == '1') ? '<RedirectURL>' . url('/') . '/api/application/redirecturl/' . $this->redirecturl_encrypt($client_response['leadid']) . '</RedirectURL>' : '';
        $res .= ($client_response['status'] == '1' && !empty($client_response['Threshold'])) ? '<Threshold>' . $client_response['Threshold'] . '</Threshold>' : '';
        $res .= ($client_response['status'] == '1' && !empty($client_response['ThresholdAmount'])) ? '<ThresholdAmount>' . $client_response['ThresholdAmount'] . '</ThresholdAmount>' : '';
//         $res .= ($client_response['status'] == '2') ? '<Descriptions>' . $client_response['Descriptions'] . '</Descriptions>' : '';
//         $res .= ($client_response['status'] == '2') ? '<PercentageComplete>' . $client_response['PercentageComplete'] . '</PercentageComplete>' : '';
//        $res .= isset($client_response['correlation_id']) ? '<CorrelationId>' . $client_response['correlation_id'] . '</CorrelationId>' : '';
//        $res .= ($client_response['status'] == '1') ? '<LenderFound>' . $client_response['LenderFound'] . '</LenderFound>' : '';
        $res .= isset($client_response['check_status_id']) ? '<CheckStatusID>' . $client_response['check_status_id'] . '</CheckStatusID>' : '';
        $res .= isset($client_response['check_status']) ? '<CheckStatus>' . $client_response['check_status'] . '</CheckStatus>' : '';
//        $res .= isset($client_response['errors']) ? '<Errors>' . $client_response['errors'] . '</Errors>' : '';

        //Errors setting up
//        $res .= isset($client_response['check_status']) ? '<CheckStatus>' . $client_response['check_status'] . '</CheckStatus>' : '';

        $res .= isset($client_response['postback_method']) ? '<PostbackMethod>' . $client_response['postback_method'] . '</PostbackMethod>' : '';
        $res .= isset($client_response['iframe_url']) ? '<IframeURL>' . $client_response['iframe_url'] . '</IframeURL>' : '';
        $res .= '</PostResponse>';
        return $res;
    }

    /**
     * 'random' feature -> inactive
     * 'lead_post' -> default
     *
     * @param $row
     * @param string $type
     */
    public function GetBuyerObject($row, $type = 'lead_post')
    {
        if ($row->post_url_live == 'random') {
            $buyerIndex = $row->parameter3;
            $buyer_used_count = $row->parameter2;
            $buyer_total_count = $row->parameter1;


            $buyers = json_decode(trim($row->notes));
            if ($type == 'lead_post') {
                $buyer_used_count++;
                if ($buyer_used_count > $buyer_total_count) {
                    $buyerIndex++;
                    if ($buyerIndex >= count($buyers)) {
                        $buyerIndex = 0;
                    }
                    $buyer_used_count = 1;
                }
                $buyer = (new Buyersetup)->UpdateParameters(
                    $row->buyersetupid,
                    $buyer_total_count,
                    $buyer_used_count,
                    $buyerIndex
                );
            }

            $buyer = $buyers[$buyerIndex];
            $search['leadtype'] = $this->leadtype;
            $search['buyerid'] = $buyer->buyerid;
            $search['setupid'] = $buyer->setupid;

            $v = Pubbuyermapping::GetSingleBuyer($search);
            $row = (object)$v[0];
        }

        return $row;
    }

    /*
     * This function handles the redirection url
     */

    public function redirecturl_encrypt($id)
    {
        return $secure = rand(10, 99) . $id . rand(10, 99);
    }
}
