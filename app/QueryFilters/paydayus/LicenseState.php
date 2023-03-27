<?php


namespace App\QueryFilters\paydayus;

use App\Models\Lead\USLead;
use App\Models\Buyer\BuyerFilterUS;
use App\QueryFilters\MultipleChoiceFilter\ShouldBe;
use App\QueryFilters\MultipleChoiceFilter\ShouldContain;
use App\QueryFilters\MultipleChoiceFilter\ShouldEndWith;
use App\QueryFilters\MultipleChoiceFilter\ShouldNotContain;
use App\QueryFilters\MultipleChoiceFilter\ShouldNotEndWith;
use App\QueryFilters\NumericFilter\ShouldBeBetween;
use App\QueryFilters\NumericFilter\ShouldBeGreaterThan;
use App\QueryFilters\NumericFilter\ShouldBeLessThan;

class LicenseState
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
            if ($key_filter['filter_type'] === 'ResidentialStatus') {
                $filter_type = 'ResidentialStatus';
                $key_filter['conditions'] = json_decode($key_filter['conditions']);

                if (!empty($key_filter['conditions']->shouldContain)) {
                    $value = $key_filter['conditions']->shouldContain;
                    $post = (new ShouldContain)->applyFilters($post, $value, $key_filter['id'], $filter_type);
                }

                if (!empty($key_filter['conditions']->shouldEndWith)) {
                    $value = $key_filter['conditions']->shouldEndWith;
                    $post = (new shouldEndWith)->applyFilters($post, $value, $key_filter['id'], $filter_type);
                }

                if (!empty($key_filter['conditions']->shouldBe)) {
                    $value = $key_filter['conditions']->shouldBe;
                    $post = (new shouldBe)->applyFilters($post, $value, $key_filter['id'], $filter_type);
                }

                if (!empty($key_filter['conditions']->shouldNotContain)) {
                    $value = $key_filter['conditions']->shouldNotContain;
                    $post = (new shouldNotContain)->applyFilters($post, $value, $key_filter['id'], $filter_type);
                }

                if ($key_filter['conditions']->shouldNotEndWith !== null) {
                    $value = $key_filter['conditions']->shouldNotEndWith;
                    $post = (new ShouldNotEndWith)->applyFilters($post, $value, $key_filter['id'], $filter_type);
                }
            }
        }

        return $post;
    }
}
