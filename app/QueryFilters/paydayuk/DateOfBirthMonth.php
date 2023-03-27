<?php


namespace App\QueryFilters\paydayuk;


use App\Models\Lead\UKLead;
use App\Models\Buyer\BuyerFilter;
use App\QueryFilters\DatesFilter\MonthFilter\MonthsBetween;
use App\QueryFilters\DatesFilter\MonthFilter\MonthsMax;
use App\QueryFilters\DatesFilter\MonthFilter\MonthsMin;


class DateOfBirthMonth
{

    public function applyFilters($lead)
    {
        $post = $lead;

        // Get the buyers mapped with VID / Vendor ID
//        $post = LmsPaydayUK::getBuyers($post);

        $buyer_list['row'] = $post->buyer_list;

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

                                if ($condition == "dmsbal") {
                                        $values = [];
                                    array_push($values, $val['values']);
                                    $post = (new MonthsMin)->applyFilters($post, $values, $buyerTierID, 'dmsbal');
                                }
                                if ($condition == "dmsbam") {
                                        $values = [];
                                    array_push($values, $val['values']);
                                    $post = (new MonthsMax)->applyFilters($post, $values1, $buyerTierID, 'dmsbam');
                                }
                                if ($condition == "dmsbb") {
                                        $values = [];
                                    array_push($values, $val['values']);
                                    $post = (new MonthsBetween)->applyFilters($post, $values2, $buyerTierID, 'dmsbb');
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
