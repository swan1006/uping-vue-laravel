<?php


namespace App\QueryFilters\paydayca\MultipleChoiceFilter;



//use App\LmspaydayUK;
use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
use Illuminate\Support\Facades\DB;


class ShouldBeBetween extends Filter
{


    public function applyFilters(
        $builder,
        $values,
        $buyerTierID,
        $condition
    )
    {
        $post = $builder;

        $query = DB::table('lmspayday_c_a_s')->where('id', $post->id);

        switch ($condition) {
            case 'mssbb':
                $keyColumn = 'maritalStatus';
                break;
            case 'esbb':
                $keyColumn = 'Email';
                break;
            case 'isssbb':
                $keyColumn = 'IncomeSource';
                break;
            case 'icsbb':
                $keyColumn = 'IncomeCycle';
                break;
            case 'rssbb':
                $keyColumn = 'ResidentialStatus';
                break;
        }
        $query->whereBetween($keyColumn, [$values[0], $values[1]]);

        $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {
            $query->whereBetween($keyColumn, [$values[0], $values[1]]); // TODO CHECK
        } elseif (empty($newQuery)) {

            $filteredTierID = BuyerFilterCA::getAllFailedFiltersByIds(
                $buyerTierID,
                $condition,
                $post->$keyColumn,
                '<>'
            );

            $tierIndex = BuyerFilterCA::getTierIndex($buyerTierID, $filteredTierID);

            $post['buyer_list'] = json_decode(json_encode($post['buyer_list']), true);

            $post = BuyerFilterCA::removeBuyerFromBuyerList($post, $tierIndex);

            return $post;
        }
    }
}

// Hello, done
// thanks i see, now please SC & SB filter to finish, i will check once over all later and double check.
//
