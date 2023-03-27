<?php


namespace App\QueryFilters\paydayca\NumericFilter;

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

        if(empty(count($values))) {
            return $post;
        }

        $query = DB::table('lmspayday_c_a_s')->where('id', $post->id);

        switch ($condition) {
            case 'misbb':
                $keyColumn = 'monthlyIncome';
                break;
            case 'lasbb':
                $keyColumn = 'loanAmount';
                break;
            case 'mmrsbb':
                $keyColumn = 'monthlyMortgageRent';
                break;
            case 'mccsbb':
                $keyColumn = 'monthlyCreditCommitments';
                break;
            case 'maasbb':
                $keyColumn = 'monthsAtAddress';
                break;
            case 'ltsbb':
                $keyColumn = 'loanTerms';
                break;
            case 'mrsbb':
                $keyColumn = 'monthlyRepayments';
                break;
            case 'mtsbb':
                $keyColumn = 'monthlyTransport';
                break;
            case 'moesbb':
                $keyColumn = 'otherExpense';
                break;
            case 'musbb':
                $keyColumn = 'monthlyUtilities';
                break;
            case 'mfsbb':
                $keyColumn = 'monthlyFood';
                break;

        }

        $query
            ->where($keyColumn, '>', $values[0][0])
            ->where($keyColumn, '<', $values[0][1]);
        $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {

            $query
//                ->whereBetween($keyColumn, [$values[0][0], $values[0][1]]);
                ->where($keyColumn, '>', $values[0][0])
                ->where($keyColumn, '<', $values[0][1]);

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

