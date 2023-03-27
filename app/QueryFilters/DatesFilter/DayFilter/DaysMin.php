<?php


namespace App\QueryFilters\DatesFilter\DayFilter;



use App\Models\BuyerFilter;
use App\Models\BuyerFilterUS;
use App\QueryFilters\Filter;
use Illuminate\Support\Facades\DB;


class DaysMin extends Filter
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
            case 'ddsbal':
                $query = DB::table('applicants')->where('lead_id', $post->id);
                $keyColumn = 'dateOfBirthDay';
                break;
            case 'npdbal':
                $query = DB::table('employers')->where('lead_id', $post->id);
                $keyColumn = 'nextPayDateDay';
                break;
            case 'fpdbal':
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
