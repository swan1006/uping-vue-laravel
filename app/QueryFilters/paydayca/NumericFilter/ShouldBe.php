<?php


namespace App\QueryFilters\paydayca\NumericFilter;



use App\Models\BuyerFilterCA;
use App\QueryFilters\paydayca\Filter;
use Illuminate\Support\Facades\DB;


class ShouldBe extends Filter
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
            case 'misb':
                $keyColumn = 'monthlyIncome';
                break;
            case 'lasb':
                $keyColumn = 'loanAmount';
                break;
            case 'mmrsb':
                $keyColumn = 'monthlyMortgageRent';
                break;
            case 'mccsb':
                $keyColumn = 'monthlyCreditCommitments';
                break;
            case 'maasb':
                $keyColumn = 'monthsAtAddress';
                break;
            case 'ltsb':
                $keyColumn = 'loanTerms';
                break;
            case 'mrsb':
                $keyColumn = 'monthlyRepayments';
                break;
            case 'mtsb':
                $keyColumn = 'monthlyTransport';
                break;
            case 'moesb':
                $keyColumn = 'otherExpense';
                break;
            case 'musb':
                $keyColumn = 'monthlyUtilities';
                break;
            case 'mfsb':
                $keyColumn = 'monthlyFood';
                break;
        }

        $query->where($keyColumn, '=', $values[0][0]);

        $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {

            $query->where($keyColumn, '=', $values[0][0]);

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

