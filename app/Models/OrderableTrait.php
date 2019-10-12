<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

trait OrderableTrait {

    public function scopeOrdered(Builder $query, array $sorter=[]) : Builder
    {
        $sort_on = $sorter['sort_on'];
        $sort_direction = array_key_exists('is_sort_asc', $sorter)
            ? ($sorter['is_sort_asc'] ? 'asc' : 'desc')
            : 'asc'; // default is asc
        $query->orderBy($sort_on, $sort_direction);
        return $query;
    }

}
