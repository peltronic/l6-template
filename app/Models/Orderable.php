<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

interface Orderable {

    public function scopeOrdered(Builder $query, array $sorter=[]) : Builder;

}
