<?php


namespace App\QueryFilters\paydayus;

use App\Models\Buyer\BuyerFilterUS;
use App\Models\Lead\USLead;
use App\QueryFilters\MultipleChoiceFilter\ShouldBe;
use App\QueryFilters\MultipleChoiceFilter\ShouldContain;
use App\QueryFilters\NumericFilter\ShouldBeBetween;
use App\QueryFilters\NumericFilter\ShouldBeGreaterThan;
use App\QueryFilters\NumericFilter\ShouldBeLessThan;

class InMilitary
{

    public function applyFilters($lead)
    {
        $post = $lead;

        $buyer_list['row'] = $post->buyer_list;

        if ($buyer_list['row'] == null) {
            return $post;
        }

        // Get the tier id/buyer setup id of each buyer mapped with the VID.
        $buyerTierID = BuyerFilterUS::getBuyerTierIds($buyer_list['row']);

        // Get the filter of each buyer using the tier id.
        $filters['row'] = BuyerFilterUS::getBuyerFilters($buyerTierID);


        /* Loop through the filters and grab conditions & values.  */
        foreach ($filters['row'] as $key_filter) {
            if ($key_filter['filter_type'] === 'InMilitary') {
                $filter_type = 'InMilitary';
                $key_filter['conditions'] = json_decode($key_filter['conditions']);

                if ($key_filter['conditions']->shouldBeGreaterThan !== null) {
                    $value = $key_filter['conditions']->shouldBeGreaterThan;
                    $post = (new ShouldBeGreaterThan)->applyFilters($post, $value, $key_filter['id'], $filter_type);
                }
                if ($key_filter['conditions']->shouldBeLessThan !== null) {
                    $value = $key_filter['conditions']->shouldBeLessThan;
                    $post = (new ShouldBeLessThan)->applyFilters($post, $value, $key_filter['id'], $filter_type);
                }
                if ($key_filter['conditions']->shouldBeBetween1 !== null && $key_filter['conditions']->shouldBeBetween2 !== null) {
                    $values[] = $key_filter['conditions']->shouldBeBetween1;
                    $values[] = $key_filter['conditions']->shouldBeBetween2;
                    $post = (new ShouldBeBetween)->applyFilters($post, $values, $key_filter['id'], $filter_type);
                }
                if ($key_filter['conditions']->shouldBe !== null) {
                    $values = $key_filter['conditions']->shouldBe;
                    $post = (new \App\QueryFilters\NumericFilter\ShouldBe)->applyFilters($post, $values, $key_filter['id'], $filter_type);
                }
            }
        }



        return $post;
    }


}
