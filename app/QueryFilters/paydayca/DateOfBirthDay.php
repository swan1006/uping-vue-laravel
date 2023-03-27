<?php


namespace App\QueryFilters\paydayca;



use App\Models\BuyerFilterCA;
use App\Models\LmsPaydayCA;
use App\QueryFilters\paydayca\DatesFilter\DayFilter\DaysMax;
use App\QueryFilters\paydayca\DatesFilter\DayFilter\DaysBetween;
use App\QueryFilters\paydayca\DatesFilter\DayFilter\DaysMin;

class DateOfBirthDay
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
                            //var_dump($condition);
                            $array[] = $condition;

                            if ($condition == "ddsbal") {
                                $values[] = $val1['values'];
                            } else if ($condition == "ddsbam") {
                                $values1[] = $val1['values'];
                            } else if ($condition == "ddsbb") {
                                $values2[] = $val1['values'];
                            }
                        }
                    }
                }
            }
        }

        $post = (new DaysMin)->applyFilters($post, $values, $buyerTierID, 'ddsbal');

        $post = (new DaysMax)->applyFilters($post, $values1, $buyerTierID, 'ddsbam');

        $post = (new DaysBetween)->applyFilters($post, $values2, $buyerTierID, 'ddsbb');

        return $post;
    }
}

