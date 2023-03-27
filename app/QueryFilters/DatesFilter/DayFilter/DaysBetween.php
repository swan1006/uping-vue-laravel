<?php


namespace App\QueryFilters\DatesFilter\DayFilter;


use App\Models\BuyerFilter;
use App\QueryFilters\Filter;
use Illuminate\Support\Facades\DB;

class DaysBetween extends Filter
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
            case 'ddsbb':
                $query = DB::table('applicants')->where('lead_id', $post->id);
                $keyColumn = 'dateOfBirthDay';
                break;
            case 'npdsbb':
                $query = DB::table('employers')->where('lead_id', $post->id);
                $keyColumn = 'nextPayDateDay';
                break;
            case 'fpdsbb':
                $query = DB::table('employers')->where('lead_id', $post->id);
                $keyColumn = 'followingPayDateDay';
                break;
        }

        $query
//            ->whereBetween($keyColumn, [$values[0][0], $values[0][1]]);
            ->where($keyColumn, '>=', [$values[0][0]])
            ->where($keyColumn, '<=', [$values[0][1]]);

        $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {

            $query
//            ->whereBetween($keyColumn, [$values[0][0], $values[0][1]]);
                ->where($keyColumn, '>=', [$values[0][0]])
                ->where($keyColumn, '<=', [$values[0][1]]);

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
