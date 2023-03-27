<?php


namespace App\QueryFilters\paydayca\DatesFilter\DayFilter;



use App\Models\LmsPaydayCA;
use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
use Illuminate\Support\Facades\DB;


class DaysMax extends Filter
{

    // Days max should be at least
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
            case 'ddsbam':
                $keyColumn = 'dateOfBirthDay';
                break;
            case 'npdbam':
                $keyColumn = 'nextPayDateDay';
                break;
            case 'fpdbam':
                $keyColumn = 'followingPayDateDay';
                break;
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

                $post = BuyerFilterCA::removeBuyerFromBuyerList(
                    $post,
                    $tierIndex
                );
            }
        }
            return $post;
    }
}
