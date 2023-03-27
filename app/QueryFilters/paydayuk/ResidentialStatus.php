<?php


namespace App\QueryFilters\paydayuk;


use App\Models\Lead\UKLead;
use App\Models\Buyer\BuyerFilter;
use App\QueryFilters\MultipleChoiceFilter\ShouldBe;
use App\QueryFilters\MultipleChoiceFilter\ShouldContain;
use App\QueryFilters\MultipleChoiceFilter\ShouldEndWith;
use App\QueryFilters\MultipleChoiceFilter\ShouldNotContain;
use App\QueryFilters\MultipleChoiceFilter\ShouldNotEndWith;

class ResidentialStatus
{
    public function applyFilters($lead)
    {
        $post = $lead;

        // Get the buyers mapped with VID / Vendor ID
//        $post = LmsPaydayUK::getBuyers($post);



        $buyer_list['row'] = $post->buyer_list;

        if ($buyer_list['row'] == null) {
            return $post;
        }


        // Get the tier id/buyer setup id of each buyer mapped with the VID.
        $buyerTierID = BuyerFilter::getBuyerTierIds($buyer_list['row']);

        // Get the filter of each buyer using the tier id.
        $filters['row'] = BuyerFilter::getBuyerFilters($buyerTierID);

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
