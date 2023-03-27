<?php


namespace App\QueryFilters\paydayca\MultipleChoiceFilter;



//use App\LmspaydayUK;
use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
use Illuminate\Support\Facades\DB;


class ShouldNotEndWith extends Filter
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

        $query = DB::table('lmspayday_c_a_s')->where('id', $post->id);

        switch ($condition) {
            case 'mssnew':
                $keyColumn = 'maritalStatus';
                break;
            case 'esnew':
                $keyColumn = 'Email';
                break;
            case 'issb':
                $keyColumn = 'IncomeSource';
                break;
            case 'icsb':
                $keyColumn = 'IncomeCycle';
                break;
            case 'rssb':
                $keyColumn = 'ResidentialStatus';
                break;
        }

        $myArray = explode(',', $values[0][0]);
        if (is_array($myArray)) {
            foreach ($myArray as $k => $v) {
                $myArray[$k] = trim($v);
            }
        }

        $query->where(function($query) use($keyColumn, $myArray) { // line 57 keycolumn issue
            foreach ($myArray as $key) {
//                var_dump($key);
                $query->where($keyColumn, 'not like', '%'. $key);
            }
        });


        $newQuery = $query->get()->toArray();


        if (!empty($newQuery)) {
            $query->where(function($query) use($keyColumn, $myArray) { // line 57 keycolumn issue TODO CHECK
                foreach ($myArray as $key) {
//                var_dump($key);
                    $query->where($keyColumn, 'not like', '%'. $key);
                }
            });
        } else {
            $filteredTierID = BuyerFilterCA::getAllFailedFiltersByIds(
                $buyerTierID,
                $condition,
                $keyColumn,
//                '='
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

