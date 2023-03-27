<?php


namespace App\QueryFilters\paydayca;

use App\Models\LmspaydayUK;
use App\Models\BuyerFilterCA;
use App\Models\LmsPaydayCA;
use App\QueryFilters\paydayca\DatesFilter\DayFilter\DaysMin;
use App\QueryFilters\paydayca\DatesFilter\DayFilter\DaysMax;
use App\QueryFilters\paydayca\DatesFilter\DayFilter\DaysBetween;

class FollowingPayDateDay
{
    public function applyFilters($lead)
    {
        $post = $lead;

        // Get the buyers mapped with VID / Vendor ID
        $post = LmsPaydayCA::getBuyers($post);

        $buyer_list['row'] = $post->buyer_list;

        // Get the tier id/buyer setup id of each buyer mapped with the VID.
        $buyerTierID = BuyerFilterCA::getBuyerTierIds($buyer_list['row']);

        // Get the filter of each buyer using the tier id.
        $filters['row'] = BuyerFilterCA::getBuyerFilters($buyerTierID);

        /*
        * Loop through the filters and grab conditions & values.
        */
        $array = array();
        $values = array();
        $values1 = array();
        $values2 = array();

        foreach ($filters['row'] as $key => $filter) {
            if (is_array($filter)) {
                foreach ($filter as $val) {
                    if (is_array($val)) {
                        foreach ($val as $val1) {

                            $condition = $val1['condition'];
                            $array[] = $condition;

                            if ($condition == "fpdbal") {
                                $values[] = $val1['values'];
                            } else if ($condition == "fpdbam") {
                                $values1[] = $val1['values'];
                            } else if ($condition == "fpdsbb") {
                                $values2[] = $val1['values'];
                            } elseif
                            (! $condition == 'fpdbal' && 'fpdbam' && 'fpdsbb') {

                                return $post;
                            }
                        }
                    }
                }
            }
        }
        $post = (new DaysMin)->applyFilters($post, $values, $buyerTierID, 'fpdbal');

        $post = (new DaysMax)->applyFilters($post, $values1, $buyerTierID, 'fpdbam');

        $post = (new DaysBetween)->applyFilters($post, $values2, $buyerTierID, 'fpdsbb');

        return $post;
    }

}
