<?php


namespace App\QueryFilters\MultipleChoiceFilter;



use App\Models\Buyer\BuyerFilter;
use App\QueryFilters\Filter;
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

        if ($post->buyer_list == null) {
            return $post;
        }


        switch ($condition) {
            case 'MaritalStatus':
                $query = DB::table('applicants')->where('id', $post->id);
                $keyColumn = 'maritalStatus';
                break;
            case 'Email':
                $query = DB::table('applicants')->where('id', $post->id);
                $keyColumn = 'email';
                break;
            case 'IncomeSource':
                $query = DB::table('employers')->where('id', $post->id);
                $keyColumn = 'incomeSource';
                break;
            case 'IncomeCycle':
                $query = DB::table('employers')->where('id', $post->id);
                $keyColumn = 'incomeCycle';
                break;
            case 'ResidentialStatus':
                $query = DB::table('residences')->where('id', $post->id);
                $keyColumn = 'residentialStatus';
                break;
            case 'InMilitary':
                $query = DB::table('applicants')->where('id', $post->id);
                $keyColumn = 'inMilitary';
                break;
            case 'LicenseState':
                $keyColumn = 'licenseState';
                break;
            case 'State':
                $query = DB::table('county')->where('id', $post->id);
                $keyColumn = 'state';
                break;
            case 'BankAccountType':
                $query = DB::table('banks')->where('id', $post->id);
                $keyColumn = 'bankAccountType';
                break;
        }

        $query->where($keyColumn, '=', $values);

        $newQuery = $query->get()->toArray();

//        dd($newQuery);
        if (!empty($newQuery)) {

            return $post;

        } else {
            $post = BuyerFilter::removeBuyerFromBuyerList(
                $post,
                $buyerTierID
            );
        }
        return $post;
    }
}


