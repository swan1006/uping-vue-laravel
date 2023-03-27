<?php


namespace App\QueryFilters\paydayca;

use App\Models\LmspaydayUK;
use App\Models\BuyerFilterCA;
use App\Models\LmsPaydayCA;
use App\QueryFilters\paydayca\MultipleChoiceFilter\ShouldBe;
use App\QueryFilters\paydayca\MultipleChoiceFilter\ShouldContain;
use App\QueryFilters\paydayca\MultipleChoiceFilter\ShouldEndWith;
use App\QueryFilters\paydayca\MultipleChoiceFilter\ShouldMatchRegEx;
use App\QueryFilters\paydayca\MultipleChoiceFilter\ShouldNotContain;
use App\QueryFilters\paydayca\MultipleChoiceFilter\ShouldNotEndWith;


class Email
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
        $values3 = array();
        $values4 = array();
        $values5 = array();
        $values6 = array();

        foreach ($filters['row'] as $key => $filter) {
            if (is_array($filter)) {
                foreach ($filter as $val) {
                    if (is_array($val)) {
                        foreach ($val as $val1) {

                            $condition = $val1['condition'];
                            $array[] = $val1['condition'];

                            if ($condition == "esc") {
                                $values1[] = $val1['values'];
                            } else if ($condition == "esew") {
                                $values2[] = $val1['values'];
                            } else if ($condition == "esb") {
                                $values3[] = $val1['values'];
                            } else if ($condition == "esmre") {
                                $values4[] = $val1['values'];
                            } else if ($condition == "esnc") {
                                $values5[] = $val1['values'];
                            } else if ($condition == "esnew") {
                                $values6[] = $val1['values'];
                            } elseif
                            (
                                !$condition ==
                                'esc' &&
                                'esew' &&
                                'esb' &&
                                'esmre' &&
                                'esnc' &&
                                'esnew'
                            ) {
                                return $post;
                            }
//                            dd($val['values'][0]);
                        }
                    }
                }
            }
        }
        $post = (new ShouldContain)->applyFilters($post, $values1, $buyerTierID, 'esc');

        $post = (new ShouldEndWith)->applyFilters($post, $values2, $buyerTierID, 'esew');

        $post = (new ShouldBe)->applyFilters($post, $values3, $buyerTierID, 'esb');

        $post = (new ShouldMatchRegEx)->applyFilters($post, $values4, $buyerTierID, 'esmre'); // TODO Finish/finalise

        $post = (new ShouldNotContain)->applyFilters($post, $values5, $buyerTierID, 'esnc');

        $post = (new ShouldNotEndWith)->applyFilters($post, $values6, $buyerTierID, 'esnew');

        return $post;
    }

}
