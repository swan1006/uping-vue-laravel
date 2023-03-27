<?php


namespace App\QueryFilters\DatesFilter\MonthFilter;


use App\Models\LmsPaydayUK;
use App\Models\BuyerFilter;
use App\QueryFilters\Filter;
use Illuminate\Support\Facades\DB;

class MonthsBetween extends Filter
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

        switch ($condition) {
            case 'dmsbb':
                $query = DB::table('applicants')->where('lead_id', $post->id);
                $keyColumn = 'dateOfBirthMonth';
                break;
        }

//        $query = DB::table('lms')->where('id', $post->id);

        $query
//            ->whereBetween($keyColumn, [$values[0][0], $values[0][1]]);
        ->where($keyColumn, '>=', [$values[0][0]])
        ->where($keyColumn, '<=', [$values[0][1]]);

        $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {
            $query
//                ->whereBetween($keyColumn, [$values[0][0], $values[0][1]]);
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
