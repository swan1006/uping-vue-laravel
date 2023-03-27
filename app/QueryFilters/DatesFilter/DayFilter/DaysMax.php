<?php


namespace App\QueryFilters\DatesFilter\DayFilter;



use App\Models\LmspaydayUK;
use App\Models\BuyerFilter;
use App\QueryFilters\Filter;
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

//        $query = DB::table('lms')->where('id', $post->id);

        switch ($condition) {
            case 'ddsbam':
                $query = DB::table('applicants')->where('lead_id', $post->id);
                $keyColumn = 'dateOfBirthDay';
                break;
            case 'npdbam':
                $query = DB::table('employers')->where('lead_id', $post->id);
                $keyColumn = 'nextPayDateDay';
                break;
            case 'fpdbam':
                $query = DB::table('employers')->where('lead_id', $post->id);
                $keyColumn = 'followingPayDateDay';
                break;
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
