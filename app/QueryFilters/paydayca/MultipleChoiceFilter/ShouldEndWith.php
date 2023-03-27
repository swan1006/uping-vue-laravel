<?php


namespace App\QueryFilters\paydayca\MultipleChoiceFilter;


//use App\LmspaydayUK;
use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
use Illuminate\Support\Facades\DB;


class ShouldEndWith extends Filter
{
    public function applyFilters(
        $builder,
        $values,
        $buyerTierID,
        $condition
    )
    {
        $post = $builder;

        if (empty(count($values))) {
            return $post;
        }

        $query = DB::table('lmspayday_c_a_s')->where('id', $post->id);

        switch ($condition) {
            case 'mssew':
                $keyColumn = 'maritalStatus';
                break;
            case 'esew':
                $keyColumn = 'Email';
                break;
            case 'issew':
                $keyColumn = 'IncomeSource';
                break;
            case 'icsew':
                $keyColumn = 'IncomeCycle';
                break;
            case 'rssew':
                $keyColumn = 'ResidentialStatus';
                break;
        }

//        dd($values);
        $myArray = explode(',', $values[0][0]);
        if (is_array($myArray)) {
            foreach ($myArray as $k => $v) {
                $myArray[$k] = trim($v);
            }
        }
        $query->where(function ($query) use ($keyColumn, $myArray) {
            foreach ($myArray as $key) {
                $query->orWhere($keyColumn, 'like', '%' . $key);
            }
        });

        $newQuery = $query->get()->toArray();


        if (!empty($newQuery)) {

            $query->where(function ($query) use ($keyColumn, $myArray) {
                foreach ($myArray as $key) {
                    $query->orWhere($keyColumn, 'like', '%' . $key);
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

