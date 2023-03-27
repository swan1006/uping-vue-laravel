<?php


namespace App\QueryFilters\paydayca\DatesFilter\MonthFilter;


use App\Models\LmsPaydayCA;
use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
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
                $keyColumn = 'dateOfBirthMonth';
                break;
        }

        $query = DB::table('lmspayday_c_a_s')->where('id', $post->id);

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
