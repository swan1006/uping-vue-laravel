<?php


namespace App\QueryFilters\DatesFilter\MonthFilter;


use App\Models\BuyerFilter;
use App\QueryFilters\Filter;
use Illuminate\Support\Facades\DB;


class MonthsMin extends Filter
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

//        $query = DB::table('lms')->where('id', $post->id);

        switch ($condition) {
            case 'dmsbal':
                $query = DB::table('applicants')->where('lead_id', $post->id);
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

            $filteredTierID = BuyerFilter::getAllFailedFiltersByIds(
                $buyerTierID,
                $condition,
                $keyColumn
            );

            $tierIndex = $filteredTierID[0];


            $post = BuyerFilter::removeBuyerFromBuyerList(
                $post,
                $tierIndex
            );
        }

        return $post;
    }
}
