<?php


namespace App\QueryFilters\TextFilter;



use App\LmspaydayUK;
use App\Models\BuyerFilterUS;
use App\QueryFilters\paydayuk\Filter;


class SMRE extends Filter
{


    protected function applyFilters($builder)
    {
        // dd(123);

        /*
        * Get the current post.
        */
        $post = $builder->get()->toArray();
        $post = $post[0];

        /*
        * Get the buyers mapped with VID.
        */
        $post = LmspaydayUK::getBuyers($post);
        $buyer_list['row'] = $post['buyer_list'];
        $buyer_list['row'] = json_decode(json_encode($buyer_list['row']), true);

        /*
        * Get the tier id/buyer setup id of each buyer mapped with the VID.
        */
        foreach ($buyer_list['row'] as $buyer) {
            $buyerTierID[] = $buyer['buyersetup_id'];
        }

        /*
        * Get the filter of each buyer using the tier id.
        */
        $filters['row'] = BuyerFilterUS::getBuyerFilters($buyerTierID);
//        dd($filters);


        /*
        * Instantiate a new builder instance.
        */
        $builder = new LmspaydayUK;
        $post = $builder->fill($post);

        /*
        * Loop through the filters and grab conditions & values.
        */

        $condition_value_max = 0;
        $condition_value_min = 0;
        $filteredTierID = [];

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
                            // dd($condition);
                            //$values[] = $val1['values'];
                            // dd($values);
                            // var_dump($values);


                            if ($condition == "ddsbam") {
                                $values1[] = $val1['values'];
                            } else if ($condition == "ddsbal") {
                                $values[] = $val1['values'];
                            } else if ($condition == "ddsbb") {
                                $values2[] = $val1['values'];
                            }


                            if ($condition === 'ddsbal') {
                                // dd(123);

                                //dd("inside ddsbal 123");
                                $filter_results[] = $val;
                                // dd($filter_results);

                                // $array[] = $values[$key][0];

                                // dd($values);
                                $recodes = array();
                                $temp_dateOfBirthday = [];
                                foreach ($values as $key => $dateOfBirthDay) {
                                    $temp_dateOfBirthday[] = $dateOfBirthDay[0];
                                }
                                $minBirth = min($temp_dateOfBirthday);
                                // dd($minBirth);
                                $query = $post->where('dateOfBirthDay', '<=', $minBirth)->get()->toArray();
                                // $query = $post->where('dateOfBirthDay', '>=', 1)->toSql();
                                // dd($query);

                                if (!empty($query)) {
                                    $post->where('dateOfBirthDay', '>=', $values)->get();
                                } elseif (empty($query)) {
                                    // dd(123);

                                    $filteredTierID = BuyerFilterUS::getAllFailedFiltersByIds($buyerTierID, $condition);
                                    // dd($filteredTierID);
                                    $tierIndex = BuyerFilterUS::getTierIndex($buyerTierID, $filteredTierID);

                                    $post['buyer_list'] = json_decode(json_encode($post['buyer_list']), true);

                                    $post = BuyerFilterUS::removeBuyerFromBuyerList($post, $tierIndex);
                                }
                            }

                            // Difference in days should be at most


                            if ($condition === 'ddsbam') {
                                // dd(123);
                                // dd($array);
                                //dd(array_values($values1));

                                $filter_results[] = $val;

                                $query = $post->where('dateOfBirthDay', '<=', $values);
                                $query = $query->get()->toArray();

                                if (!empty($query)) {
                                    $post->where('dateOfBirthDay', '<=', $values)->get();
                                } elseif (empty($query)) {

                                    $filteredTierID = BuyerFilterUS::getAllFailedFiltersByIds($buyerTierID, $condition);

                                    $tierIndex = BuyerFilterUS::getTierIndex($buyerTierID, $filteredTierID);

                                    $post['buyer_list'] = json_decode(json_encode($post['buyer_list']), true);

                                    $post = BuyerFilterUS::removeBuyerFromBuyerList($post, $tierIndex);
                                }
                            }


                            // Difference in days should be between
                            // this logic not right. should take min and max, between dates.
                            if ($condition === 'ddsbb') {
                                // dd(123);
                                // dd($array);
                                //dd($values2[0][0]);
//                                dd($values2);

                                $filter_results[] = $val;

                                // dd($value2);
                                $query = $post
                                    ->whereBetween('dateOfBirthDay', [$values2[0][0], $values2[0][1]]);
                                // run
                                $query = $query->get()->toArray();

                                if (!empty($query)) {
                                    $post->where('dateOfBirthDay', '>=', $values)->get();
                                } elseif (empty($query)) {
//                                    dd(123);

                                    $filteredTierID = BuyerFilterUS::getAllFailedFiltersByIds($buyerTierID, $condition);

                                    $tierIndex = BuyerFilterUS::getTierIndex($buyerTierID, $filteredTierID);

                                    $post['buyer_list'] = json_decode(json_encode($post['buyer_list']), true);

                                    $post = BuyerFilterUS::removeBuyerFromBuyerList($post, $tierIndex);
                                }
                            }
                            // dd($post);
                            // return $post;
                        }

                        // dd($array);


                    }
                }
            }
        }
        dd($post);
        // 10 not being filtered. if condition fails, it should filter (empty query).
        // whereBetween('dateOfBirthDay', [$value2[0][0], $value2[0][1]]);
        // try with this
//        dd($values2);
        // dd($filter_results);
        // dd($filteredT/  ierID);
    }
}

// Hello, done
// thanks i see, now please SC & SB filter to finish, i will check once over all later and double check.
//
