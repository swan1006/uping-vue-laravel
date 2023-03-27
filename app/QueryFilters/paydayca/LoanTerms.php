<?php


namespace App\QueryFilters\paydayca;

use App\Models\LmsPaydayCA;
use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\NumericFilter\ShouldBe;
use App\QueryFilters\paydayca\NumericFilter\ShouldBeBetween;
use App\QueryFilters\paydayca\NumericFilter\ShouldBeGreaterThan;
use App\QueryFilters\paydayca\NumericFilter\ShouldBeLessThan;


class LoanTerms
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

        foreach ($filters['row'] as $key => $filter) {
            if (is_array($filter)) {
                foreach ($filter as $val) {
                    if (is_array($val)) {
                        foreach ($val as $val1) {

                            $condition = $val1['condition'];
                            $array[] = $val1['condition'];

                            if ($condition == "ltsbgt") {
                                $values1[] = $val1['values'];
                            } else if ($condition == "ltsblt") {
                                $values2[] = $val1['values'];
                            } else if ($condition == "ltsbb") {
                                $values3[] = $val1['values'];
                            } else if ($condition == "ltsb") {
                                $values4[] = $val1['values'];
//                                dd($values4);
                            } elseif
                            (
                                !$condition ==
                                'ltsbgt' &&
                                'ltsblt' &&
                                'ltsbb' &&
                                'ltsb'
                            ) {
                                return $post;
                            }
                        }
                    }
                }
            }
        }

        $post = (new ShouldBeGreaterThan)->applyFilters($post, $values1, $buyerTierID, 'ltsbgt');

        $post = (new ShouldBeLessThan)->applyFilters($post, $values2, $buyerTierID, 'ltsblt');

        $post = (new ShouldBeBetween)->applyFilters($post, $values3, $buyerTierID, 'ltsbb');

        $post = (new ShouldBe)->applyFilters($post, $values4, $buyerTierID, 'ltsb');

        return $post;
    }

}
