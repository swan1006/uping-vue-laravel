<?php



namespace App\QueryFilters\paydayca\MultipleChoiceFilter;

use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
use Illuminate\Support\Facades\DB;

class ShouldMatchRegEx extends Filter
{
    public function applyFilters($builder, $values, $buyerTierID, $condition)
    {
        $post = $builder;

        if (empty(count($values))) {
            return $post;
        }


        $query = DB::table('lmspayday_c_a_s')->where('id', $post->id);

        switch ($condition) {
            case 'mssmre':
                $keyColumn = 'maritalStatus';
                break;
            case 'esmre':
                $keyColumn = 'Email';
                break;
            case 'issmre':
                $keyColumn = 'IncomeSource';
                break;
            case 'icsmre':
                $keyColumn = 'IncomeCycle';
                break;
            case 'rssmre':
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
            ); // TODO check

//            $query->where('email', 'regexp', $myRegex);

        } else {

            $filteredTierID = BuyerFilterCA::getAllFailedFiltersByIds(
                $buyerTierID,
                $condition,
                $keyColumn,
                '='
            );

            if(count($filteredTierID)) {
                $tierIndex = BuyerFilterCA::getTierIndex(
                    $buyerTierID,
                    $filteredTierID
                );

                $post['buyer_list'] = json_decode(json_encode($post['buyer_list']), true);

                $post = BuyerFilterCA::removeBuyerFromBuyerList(
                    $post,
                    $tierIndex
                );
            }
        }
            return $post;
    }
}
