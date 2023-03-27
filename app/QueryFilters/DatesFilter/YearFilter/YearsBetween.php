<?php


namespace App\QueryFilters\DatesFilter\YearFilter;


use App\Models\BuyerFilter;
use App\QueryFilters\Filter;
use Illuminate\Support\Facades\DB;

class YearsBetween extends Filter
{
    public function applyFilters(
        $builder,
        $values,
        $buyerTierID,
        $condition
    )
    {
//        if ($buyerTierID == 3) {
//            dd($values);
//
//        }

        $post = $builder;

        if(empty(count($values))) {
            return $post;
        }

        switch ($condition) {
            case 'dysbb':
                $query = DB::table('applicants')->where('lead_id', $post->id);
                $keyColumn = 'dateOfBirthYear';
                break;
        }

        // BUYERS -> DESC.


        $query
            ->where($keyColumn, '>=', [$values[0][0]])
            ->where($keyColumn, '<=', [$values[0][1]]);

        $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {
            $query
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
