<?php


namespace App\QueryFilters\paydayca\DatesFilter\YearFilter;


use App\Models\LmspaydayCA;
use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
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
        $post = $builder;

        if(empty(count($values))) {
            return $post;
        }

        switch ($condition) {
            case 'dysbb':
                $keyColumn = 'dateOfBirthYear';
                break;
        }

        $query = DB::table('lmspayday_c_a_s')->where('id', $post->id);

        $query
            ->where($keyColumn, '>=', [$values[0][0]])
            ->where($keyColumn, '<=', [$values[0][1]]);

        $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {
            $query
                ->where($keyColumn, '>=', [$values[0][0]])
                ->where($keyColumn, '<=', [$values[0][1]]);

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

                $post = BuyerFilterCA::removeBuyerFromBuyerList(
                    $post,
                    $tierIndex
                );
            }
        }
        return $post;
    }
}
