<?php


namespace App\QueryFilters\paydayca\NumericFilter;



use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
use Illuminate\Support\Facades\DB;


class ShouldBeGreaterThan extends Filter
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
            case 'misbgt':
                $keyColumn = 'monthlyIncome';
                break;
            case 'lasbgt':
                $keyColumn = 'loanAmount';
                break;
            case 'mmrsbgt':
                $keyColumn = 'monthlyMortgageRent';
                break;
            case 'mccsbgt':
                $keyColumn = 'monthlyCreditCommitments';
                break;
            case 'maasbgt':
                $keyColumn = 'monthsAtAddress';
                break;
            case 'ltsbgt':
                $keyColumn = 'loanTerms';
                break;
            case 'mrsbgt':
                $keyColumn = 'monthlyRepayments';
                break;
            case 'mtsbgt':
                $keyColumn = 'monthlyTransport';
                break;
            case 'moesbgt':
                $keyColumn = 'otherExpense';
                break;
            case 'musbgt':
                $keyColumn = 'monthlyUtilities';
                break;
            case 'mfsbgt':
                $keyColumn = 'monthlyFood';
                break;
        }

        $query->where($keyColumn, '>=', $values[0][0]);

        $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {

            $query->where($keyColumn, '>=', $values[0][0]);

        } else {

            $filteredTierID = BuyerFilterCA::getAllFailedFiltersByIds(
                $buyerTierID,
                $condition,
                $post->$keyColumn
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

