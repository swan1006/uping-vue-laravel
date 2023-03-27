<?php



namespace App\QueryFilters\MultipleChoiceFilter;

use App\Models\BuyerFilter;
use App\QueryFilters\Filter;
use Illuminate\Support\Facades\DB;

class ShouldMatchRegEx extends Filter
{
    public function applyFilters($builder, $values, $buyerTierID, $condition)
    {
        $post = $builder;

        if (empty(count($values))) {
            return $post;
        }


//        $query = DB::table('lms')->where('id', $post->id);

        switch ($condition) {
            case 'mssmre':
                $query = DB::table('applicants')->where('lead_id', $post->id);
                $keyColumn = 'maritalStatus';
                break;
            case 'esmre':
                $query = DB::table('applicants')->where('lead_id', $post->id);
                $keyColumn = 'Email';
                break;
            case 'issmre':
                $query = DB::table('employers')->where('lead_id', $post->id);
                $keyColumn = 'IncomeSource';
                break;
            case 'icsmre':
                $query = DB::table('employers')->where('lead_id', $post->id);
                $keyColumn = 'IncomeCycle';
                break;
            case 'rssmre':
                $query = DB::table('residences')->where('lead_id', $post->id);
                $keyColumn = 'ResidentialStatus';
                break;
        }
        $myRegex = $values[0][0];
        $newQuery = DB::select(
            "SELECT * FROM `lmspaydayuks` WHERE `id` = " . $post->id .
            " AND `". $keyColumn ."` REGEXP '". $myRegex ."'"
        );

        if (!empty($newQuery)) {

            $newQuery = DB::select(
                "SELECT * FROM `lmspaydayuks` WHERE `id` = " . $post->id .
                " AND `". $keyColumn ."` REGEXP '". $myRegex ."'"
            );

//            $query->where('email', 'regexp', $myRegex);

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
