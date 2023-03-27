<?php


namespace App\QueryFilters\MultipleChoiceFilter;


use App\Models\Buyer\BuyerFilter;
use App\QueryFilters\Filter;
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
        $post = $builder;

        if (empty($post->buyer_list)) {
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

        $myArray = explode(',', $values);
        if (is_array($myArray)) {
            foreach ($myArray as $k => $v) {
                $myArray[$k] = trim($v);
            }
        }

//        dd($myArray);
        if ($keyColumn == 'email') {
           $query
               ->where(function ($email_item) use ($myArray, $keyColumn) {
                   for ($i = 0; $i < count($myArray); $i++) {
                       $email_item->orwhere($keyColumn, 'like',  '%' . $myArray[$i] .'%');
                   }
               });

        } else {
                $query->whereIn($keyColumn, $values);

        }

       $newQuery = $query->get()->toArray();

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

