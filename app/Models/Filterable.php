<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

interface Filterable {

    public function scopeFiltered(Builder $query, array $filters=[]) : Builder;

}
