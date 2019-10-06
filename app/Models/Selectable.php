<?php
namespace App\Models;

interface Selectable {

    public static function getSelectOptions($includeBlank=true, $keyField='id', $filters=[]) : array;

}
