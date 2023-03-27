<?php


namespace App\QueryFilters\paydayca\MultipleChoiceFilter;


//use App\LmspaydayUK;
use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
use Illuminate\Support\Facades\DB;


class ShouldContain extends Filter
{


    public function applyFilters(
        $builder,
        $values,
        $buyerTierID,
        $condition
    )
    {
//        DB::enableQueryLog();
        $post = $builder;

        if (empty(count($values))) {
            return $post;
        }

        $query = DB::table('lmspayday_c_a_s')->where('id', $post->id);

        switch ($condition) {
            case 'mssc':
                $keyColumn = 'maritalStatus';
                break;
            case 'esc':
                $keyColumn = 'Email';
                break;
            case 'issc':
                $keyColumn = 'IncomeSource';
                break;
            case 'icsc':
                $keyColumn = 'IncomeCycle';
                break;
            case 'rssc':
                $keyColumn = 'ResidentialStatus';
                break;
        }

        $myArray = explode(',', $values[0][0]);
        if (is_array($myArray)) {
            foreach ($myArray as $k => $v) {
                $myArray[$k] = trim($v);
            }
        }

           $query
               ->where(function ($email_item) use ($myArray, $keyColumn) {
                   for ($i = 0; $i < count($myArray); $i++){
                       $email_item->orwhere($keyColumn, 'like',  '%' . $myArray[$i] .'%');
                   }
               });

       $newQuery = $query->get()->toArray();

//       dd($newQuery);

        if (!empty($newQuery)) {
            $query
                ->Where(function ($email_item) use($myArray, $keyColumn) {
                    for ($i = 0; $i < count($myArray); $i++){
                        $email_item->orwhere($keyColumn, 'like',  '%' . $myArray[$i] .'%');
                    }
                });

        } else {

            $filteredTierID = BuyerFilterCA::getAllFailedFiltersByIds(
                $buyerTierID,
                $condition,
                $keyColumn
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
