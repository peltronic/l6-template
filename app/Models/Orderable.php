<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

interface Orderable {

    // $sorter[
    //   'sort_on'=> ...,
    //   'is_sort_asc'=> ...,
    // ]
    public function scopeOrdered(Builder $query, array $sorter=[]) : Builder;

}
