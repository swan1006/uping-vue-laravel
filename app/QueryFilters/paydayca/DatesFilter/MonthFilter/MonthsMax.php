<?php


namespace App\QueryFilters\paydayca\DatesFilter\MonthFilter;


use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
use Illuminate\Support\Facades\DB;


class MonthsMax extends Filter
{
    public function applyFilters(
        $builder,
        $values,
        $buyerTierID,
        $condition
    )
    {
        $post = $builder;

        if(empty(count($values))) {
            return $post;
        }

        $query = DB::table('lmspayday_c_a_s')->where('id', $post->id);

        switch ($condition) {
            case 'dmsbam':
                $keyColumn = 'dateOfBirthMonth';
                break;
//            case 'npdsbal':
//                $keyColumn = 'nextPayDateDay';
//                break;
//            case 'fpdsbal':
//                $keyColumn = 'followingPayDateDay';
//                break;
        }

        $query->where($keyColumn, '<=', $values[0][0]);

        $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {

            $query->where($keyColumn, '<=', $values[0][0]);

        } else {

            $filteredTierID = BuyerFilterCA::getAllFailedFiltersByIds(
                $buyerTierID,
                $condition,
                $post->$keyColumn
            );

            if(count($filteredTierID)) {
                $tierIndex = BuyerFilterCA::getTierIndex(
                    $buyerTierID,
                    $filteredTierID
                );

                $post['buyer_list'] = json_decode(json_encode($post['buyer_list']), true);

                $post = BuyerFilterCA::removeBuyerFromBuyerList(
                    $post,
                    $tierIndex
                );
            }
        }
            return $post;
    }
}
