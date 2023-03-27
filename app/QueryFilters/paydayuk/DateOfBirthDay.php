<?php


namespace App\QueryFilters\paydayuk;


use App\Models\Buyer\BuyerFilter;
use App\Models\Lead\UKLead;
use App\QueryFilters\DatesFilter\DayFilter\DaysMax;
use App\QueryFilters\DatesFilter\DayFilter\DaysBetween;
use App\QueryFilters\DatesFilter\DayFilter\DaysMin;
use Illuminate\Support\Facades\Log;

class DateOfBirthDay
{
    public function applyFilters($lead)
    {
        $post = $lead;

        dd('HERE');

        // Get the buyers mapped with VID / Vendor ID
        $post = UKLead::getBuyers($post);

        $buyer_list['row'] = $post->buyer_list;
        Log::debug('BUYER LIST1::', (array)$buyer_list['row']);

        if ($buyer_list['row']->isEmpty()) {

            return $post;
        }


        // Get the tier id/buyer setup id of each buyer mapped with the VID.
        $buyerTierID = BuyerFilter::getBuyerTierIds($buyer_list['row']);

        // Get the filter of each buyer using the tier id.
        $filters['row'] = BuyerFilter::getBuyerFilters($buyerTierID);


        /*
        * Loop through the filters and grab conditions & values.
        */
        $array = array();
        $values = array();
        $values1 = array();
        $values2 = array();

        foreach ($filters['row'] as $key_filter) {
            foreach ($key_filter as $key => $filter) {
                if (is_array($filter)) {
                    foreach ($filter as $val) {
                        if (is_array($val)) {
                            foreach ($val['values'] as $val1) {

                                $condition = $val['condition'];
                                $array[] = $condition;

                                $key_filter_tier_id = $key_filter['buyersetup_id'];


                                if ($condition == "ddsbal") {
                                    $values = [];
                                    array_push($values, $val['values']);
                                    $post = (new DaysMin)->applyFilters($post, $values, $key_filter_tier_id, 'ddsbal');
                                }
                                if ($condition == "ddsbam") {
                                    $values = [];
                                    array_push($values, $val['values']);
                                    $post = (new DaysMax)->applyFilters($post, $values, $key_filter_tier_id, 'ddsbam');
                                }
                                if ($condition == "ddsbb") {
                                    $values = [];
                                    array_push($values, $val['values']);
                                    $post = (new DaysBetween)->applyFilters($post, $values, $key_filter_tier_id, 'ddsbb');
                                }
                            }
                        }
                    }
                }
            }
        }
        return $post;
    }
}

