<?php


namespace App\QueryFilters\NumericFilter;


use App\Models\Buyer\BuyerFilter;
use App\QueryFilters\Filter;
use Illuminate\Support\Facades\DB;


class ShouldBeLessThan extends Filter
{


    public function applyFilters(
        $builder,
        $value,
        $buyerTierID,
        $condition
    )
    {
        $post = $builder;

        if ($post->buyer_list == null) {
            return $post;
        }

        switch ($condition) {
            case 'MonthlyIncome':
                $query = DB::table('employers')->where('id', $post->id);
                $keyColumn = 'monthlyIncome';
                break;
            case 'LoanAmount':
                $query = DB::table('loans')->where('id', $post->id);
                $keyColumn = 'loanAmount';
                break;
            case 'MonthlyMortgageRent':
                $query = DB::table('expenses')->where('id', $post->id);
                $keyColumn = 'monthlyMortgageRent';
                break;
            case 'MonthsAtAddress':
                $query = DB::table('residences')->where('id', $post->id);
                $keyColumn = 'monthsAtAddress';
                break;
            case 'LoanTerms':
                $query = DB::table('loans')->where('id', $post->id);
                $keyColumn = 'loanTerms';
                break;
            case 'CreditExpense':
                $query = DB::table('expenses')->where('id', $post->id);
                $keyColumn = 'creditExpense';
                break;
            case 'TransportExpense':
                $query = DB::table('expenses')->where('id', $post->id);
                $keyColumn = 'transportExpense';
                break;
            case 'OtherExpense':
                $query = DB::table('expenses')->where('id', $post->id);
                $keyColumn = 'otherExpense';
                break;
            case 'UtilityExpense':
                $query = DB::table('expenses')->where('id', $post->id);
                $keyColumn = 'utilityExpense';
                break;
            case 'FoodExpense':
                $query = DB::table('expenses')->where('id', $post->id);
                $keyColumn = 'foodExpense';
                break;
        }
        $query->where($keyColumn, '<=', $value);

        $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {

            return $post;

        } else {

            dd($buyerTierID);
            $post = BuyerFilter::removeBuyerFromBuyerList(
                $post,
                $buyerTierID
            );
        }
        return $post;
    }
}
