<?php


namespace App\QueryFilters\paydayca\NumericFilter;


use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
use Illuminate\Support\Facades\DB;


class ShouldBeLessThan extends Filter
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
            case 'misblt':
                $keyColumn = 'monthlyIncome';
                break;
            case 'lasblt':
                $keyColumn = 'loanAmount';
                break;
            case 'mmrsblt':
                $keyColumn = 'monthlyMortgageRent';
                break;
            case 'mccsblt':
                $keyColumn = 'monthlyCreditCommitments';
                break;
            case 'maasblt':
                $keyColumn = 'monthsAtAddress';
                break;
            case 'ltsblt':
                $keyColumn = 'loanTerms';
                break;
            case 'mrsblt':
                $keyColumn = 'monthlyRepayments';
                break;
            case 'mtsblt':
                $keyColumn = 'monthlyTransport';
                break;
            case 'moesblt':
                $keyColumn = 'otherExpense';
                break;
            case 'musblt':
                $keyColumn = 'monthlyUtilities';
                break;
            case 'mfsblt':
                $keyColumn = 'monthlyFood';
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
                $post->$keyColumn,
//                '<'
            );

            if (count($filteredTierID)) {
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

