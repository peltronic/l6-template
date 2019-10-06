<?php 
namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole implements Selectable
{

    // See: https://stackoverflow.com/questions/40739911/laravel-5-3-entrust-class-name-must-be-a-valid-object-or-a-string
    public function users()
    {
        return $this->belongsToMany(
            \Config::get('auth.providers.users.model'), 
            \Config::get('entrust.role_user_table'), 
            \Config::get('entrust.role_foreign_key'), 
            \Config::get('entrust.user_foreign_key'));
    }

    // --- Implement Selectable Interface ---

    public static function getSelectOptions($includeBlank=true, $keyField='id', $filters=[]) : array
    {
        $records = self::all(); // %TODO : add filter capability
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }
        foreach ($records as $i => $r) {
            switch ($r->name) {
                case 'admin':
                    continue 2; // don't make admin an option
            }
            $options[$r->{$keyField}] = $r->name;
        }
        return $options;
    }
    public function renderName() : string
    {
        return $this->display_name;
    }
}
