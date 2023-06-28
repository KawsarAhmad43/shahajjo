<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class QueryBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // WHERE LIKE QUERY BUILDER
        Builder::macro('whereLike', function ($attribute, $searchTerm) {
            if (! empty($attribute) && ! empty($searchTerm)) {
                return $this->where($attribute, 'LIKE', "%{$searchTerm}%");
            }
        });

        // WHERE DATE QUERY BUILDER
        Builder::macro('whereDates', function ($attribute, $fromDate, $toDate) {
            if (! empty($fromDate) && ! empty($toDate)) {
                $from = date('Y-m-d', strtotime($fromDate));
                $to = date('Y-m-d', strtotime($toDate));

                return $this->whereDate($attribute, '>=', $from)
                    ->whereDate($attribute, '<=', $to);
            }
        });

        // WHERE ANY EQUAL DATA QUERY BUILDER
        Builder::macro('whereAny', function ($attribute, $searchTerm) {
            if (! empty($searchTerm)) {
                return $this->where($attribute, $searchTerm);
            }
        });

        // SUB-QUERY BUILDER
        Builder::macro('whereSub', function ($subfield, $attribute, $searchTerm) {
            if (! empty($searchTerm)) {
                return $this->whereHas($subfield, function ($subquery) use ($searchTerm, $attribute) {
                    $subquery->where($attribute, $searchTerm);
                });
            }
        });

        // SUB-QUERY LIKE BUILDER
        Builder::macro('whereSubLike', function ($subfield, $attribute, $searchTerm) {
            if (! empty($searchTerm)) {
                return $this->whereHas($subfield, function ($subquery) use ($searchTerm, $attribute) {
                    $subquery->where($attribute, 'LIKE', "%{$searchTerm}%");
                });
            }
        });
    }
}
