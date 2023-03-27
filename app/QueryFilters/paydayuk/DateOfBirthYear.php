<?php
//
//
//namespace App\QueryFilters;
//
//
//use App\Buyer;
//use App\Buyersetup;
//use App\LmspaydayUK;
//use App\Models\BuyerFilter;
//use Carbon\Carbon;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Pipeline\Pipeline;
//use Illuminate\Support\Facades\DB;
//
////use function Symfony\Component\String\b;
//
//class DateOfBirthYear extends Filter
//{
//
//    protected function applyFilters($builder)
//    {
//
//        $post = LmspaydayUK::preFilterPost($builder);
//
//        // Get buyers mapped with VID.
//        $buyer_list['row'] = LmspaydayUK::getBuyers($post);
//        $post['buyer_list'] = $buyer_list['row'];
//
//        foreach ($buyer_list['row'] as $buyer)
//            $buyerTierID = $buyer->buyersetup_id;
//
//        $filters = LmspaydayUK::getTierID($buyerTierID);
//
//        $builder = new LmspaydayUK($post);
//        $builder->where('id', '=', $post['id']);
//
//
//        foreach ($filters as $k => $v) {
//            foreach ($v as $key => $value) {
//                $conditions = $v['conditions'];
//                foreach ($conditions as $condition)
//
//                    /******** refactor to pipeline *********/
//
////                app(Pipeline::class)
////                    ->send($builder)
////                    ->through([
////                        DiffInDaysMin::class,
////                        DiffInDaysMax::class,
////                        DiffInDaysBetween::class
////                        // Other filters etc...
////                    ])
////                    ->thenReturn()
////                    ->get();
////
////                return $builder;
//
//                // Days
////                Difference in years should be at least
//                if ($condition['condition'] === 'dysbal') {
//                    if (!empty($condition['values'][0])) {
//                        $condition_value = $condition['values'][0];
//                    }
//                    if (!empty($condition['values'][1])) {
//                        $condition_value_max = $condition['values'][1];
//                    }
//
//                    $builder->where('dateOfBirthYear', '>=', $condition_value);
//                }
////                Difference in years should be at most
//                if ($condition['condition'] === 'dysbam') {
//                    if (!empty($condition['values'][0])) {
//                        $condition_value = $condition['values'][0];
//                    }
//                    if (!empty($condition['values'][1])) {
//                        $condition_value_max = $condition['values'][1];
//                    }
//                    $builder->where('dateOfBirthYear', '<=', $condition_value_max);
//                }
////                Difference in years should be between
//                if ($condition['condition'] === 'dysbb') {
//                    if (!empty($condition['values'][0])) {
//                        $condition_value = $condition['values'][0];
//                    }
//                    if (!empty($condition['values'][1])) {
//                        $condition_value_max = $condition['values'][1];
//                    }
//                    $builder
//                        ->where('dateOfBirthYear', '>=', $condition_value)
//                        ->where('dateOfBirthYear', '<=', $condition_value_max);
//                }
//
//                return $builder;
//
//            }
//        }
//    }
//}


namespace App\QueryFilters\paydayuk;


use App\Models\LmsPaydayUK;
use App\Models\BuyerFilter;
use App\QueryFilters\paydayuk\DatesFilter\YearFilter\YearsBetween;
use App\QueryFilters\paydayuk\DatesFilter\YearFilter\YearsMax;
use App\QueryFilters\paydayuk\DatesFilter\YearFilter\YearsMin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;


class DateOfBirthYear
{

    public function applyFilters($lead)
    {
        $post = $lead;

        // Get the buyers mapped with VID / Vendor ID

        $buyer_list['row'] = $post->buyer_list;

        if ($buyer_list['row'] == null) {
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

//        dd($filters);
        foreach ($filters['row'] as $key_filter) {
            foreach ($key_filter as $key => $filter) {
                if (is_array($filter)) {
                    foreach ($filter as $val) {
                        if (is_array($val)) {
                            foreach ($val['values'] as $val1) {

                                $condition = $val['condition'];
                                $array[] = $condition;

                                $key_filter_tier_id = $key_filter['buyersetup_id'];

                                if ($condition == "dysbal") {
                                    $values = [];
                                    array_push($values, $val['values']);

                                    $post = (new YearsMin)->applyFilters($post, $values, $key_filter_tier_id, 'dysbal');

                                }

                                if ($condition == "dysbam") {
                                    $values = [];
                                    array_push($values, $val['values']);

                                    $post = (new YearsMax)->applyFilters($post, $values, $key_filter_tier_id, 'dysbam');

                                }

                                if ($condition == "dysbb") {
                                    $values = [];
                                    array_push($values, $val['values']);

                                    $post = (new YearsBetween)->applyFilters($post, $values, $key_filter_tier_id, 'dysbb');

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
