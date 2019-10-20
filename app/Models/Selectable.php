<?php
namespace App\Models;

interface Selectable {

    public static function getSelectOptions(bool $includeBlank=true, string $keyField='id', array $filters=[]) : array;

}
