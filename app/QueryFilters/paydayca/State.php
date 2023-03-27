<?php


namespace App\QueryFilters\paydayca;

use App\Models\LmsPaydayCA;
use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\MultipleChoiceFilter\ShouldBe;
use App\QueryFilters\paydayca\MultipleChoiceFilter\ShouldContain;

class State
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
        $values1 = array();
        $values2 = array();

        foreach ($filters['row'] as $key => $filter) {
            if (is_array($filter)) {
                foreach ($filter as $val) {
                    if (is_array($val)) {
                        foreach ($val as $val1) {

                            $condition = $val1['condition'];
                            $array[] = $val1['condition'];

                            if ($condition == "ssc") {
                                $values1[] = $val1['values'];
                            } else if ($condition == "ssb") {
                                $values2[] = $val1['values'];
                            } elseif
                            (
                                !$condition ==
                                'ssc' &&
                                'ssb'
                            ) {
                                return $post;
                            }
                        }
                    }
                }
            }
        }

        $post = (new ShouldContain)->applyFilters($post, $values1, $buyerTierID, 'ssc');

        $post = (new ShouldBe)->applyFilters($post, $values2, $buyerTierID, 'ssb');

        return $post;
    }


}
