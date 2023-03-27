<?php


namespace App\QueryFilters\paydayca\MultipleChoiceFilter;



//use App\LmspaydayUK;
use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
use Illuminate\Support\Facades\DB;


class ShouldNotContain extends Filter
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

//        $keyColumn = 'maritalStatus';
        switch ($condition) {
            case 'mssnc':
                $keyColumn = 'maritalStatus';
                break;
            case 'esnc':
                $keyColumn = 'Email';
                break;
            case 'issnc':
                $keyColumn = 'IncomeSource';
                break;
            case 'icsnc':
                $keyColumn = 'IncomeCycle';
                break;
            case 'rssnc':
                $keyColumn = 'ResidentialStatus';
                break;
        }

        $myArray = explode(',', $values[0][0]);
        if (is_array($myArray)) {
            foreach ($myArray as $k => $v) {
                $myArray[$k] = trim($v);
            }
        }
//        var_dump('start', $myArray, $keyColumn, $post->email, 'end');

        $query->where(function($query) use($keyColumn, $myArray) {
            foreach ($myArray as $key) {
                $query->where($keyColumn, 'not like', '%'. $key . '%');
            }
        });

        $newQuery = $query->get()->toArray();


        if (!empty($newQuery)) {
            $query->where(function($query) use($keyColumn, $myArray) {
                foreach ($myArray as $key) {
//                var_dump($key);
                    $query->where($keyColumn, 'not like', '%'. $key . '%');
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
