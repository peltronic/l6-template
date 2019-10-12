<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

interface Searchable {

    // $searcher can be array (with key named 'value'), or a simple string scalar
    public function scopeSearched(Builder $query, $searcher=null) : Builder;

}
