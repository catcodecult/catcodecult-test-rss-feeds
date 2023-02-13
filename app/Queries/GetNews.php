<?php

namespace App\Queries;

use App\Models\News;
use Illuminate\Support\Collection;

class GetNews
{
    /**
     * @param array $options
     * @return Collection<News>
     */
    public static function query(array $options): Collection
    {
        // Prepare requested filters
        $columns = data_get($options, 'columns', implode(',', News::getAllowedFillable()));
        $order = data_get($options, 'order', 'asc');
        $page = data_get($options, 'page', 1);

        // Filter requested columns
        $requestedColumns = explode(',', $columns);
        $allowedColumns = array_intersect($requestedColumns, News::getAllowedFillable());

        return News::query()
            ->select($allowedColumns)
            ->orderBy('published_at', $order)
            ->forPage($page, 30)
            ->get();
    }
}
