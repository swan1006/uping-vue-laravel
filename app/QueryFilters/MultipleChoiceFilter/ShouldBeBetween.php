<?php


namespace App\QueryFilters\MultipleChoiceFilter;



use App\Models\BuyerFilter;
use App\QueryFilters\Filter;
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

        $query = DB::table('lms')->where('id', $post->id);

        switch ($condition) {
            case 'mssbb':
                $query = DB::table('applicants')->where('lead_id', $post->id);
                $keyColumn = 'maritalStatus';
                break;
            case 'esbb':
                $query = DB::table('applicants')->where('lead_id', $post->id);
                $keyColumn = 'Email';
                break;
            case 'isssbb':
                $query = DB::table('employers')->where('lead_id', $post->id);
                $keyColumn = 'IncomeSource';
                break;
            case 'icsbb':
                $query = DB::table('employers')->where('lead_id', $post->id);
                $keyColumn = 'IncomeCycle';
                break;
            case 'rssbb':
                $query = DB::table('residences')->where('lead_id', $post->id);
                $keyColumn = 'ResidentialStatus';
                break;
        }
        $query->where($keyColumn, '>=', [$values[0][0]])
            ->where($keyColumn, '<=', [$values[0][1]]);

        $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {
            $query->where($keyColumn, '>=', [$values[0][0]])
                ->where($keyColumn, '<=', [$values[0][1]]);
        } elseif (empty($newQuery)) {

            $filteredTierID = BuyerFilter::getAllFailedFiltersByIds(
                $buyerTierID,
                $condition,
                $keyColumn,
//                '<>'
            );

            $tierIndex = BuyerFilter::getTierIndex($buyerTierID, $filteredTierID);

            $post['buyer_list'] = json_decode(json_encode($post['buyer_list']), true);

            $post = BuyerFilter::removeBuyerFromBuyerList($post, $tierIndex);

            return $post;
        }
    }
}
