<?php
namespace App\Models;

class Account extends BaseModel implements Selectable, Sluggable, Guidable
{
    protected $fillable = [' guid', 'slug', 'user_id', 'aname', 'adesc', 'jsonattrs'];

    // Default Validation Rules: may be overridden in controller...but NOTE these are used in renderFormLabel() and isFieldRequired() !
    public static $vrules = [
    ];

    //--------------------------------------------
    // Relations
    //--------------------------------------------

    public function listings() {
        return $this->hasMany('App\Models\Listing');
    }

    //--------------------------------------------
    // Accessors/Mutators
    //--------------------------------------------

    public function getJsonattrsAttribute($v) {
        return empty($v) ? [] : json_decode($v,true);
    }
    public function setJsonattrsAttribute($v) {
        $this->attributes['jsonattrs'] = json_encode($v);
    }

    //--------------------------------------------
    // Local Scopes
    //--------------------------------------------

    public function scopeFilterBy($query, $filters)
    {
        if ( array_key_exists('aname', $filters) ) {
            $query->where('aname', 'like', '%'.$filters['aname'].'%');
        }
        return $query;
    }

    //--------------------------------------------
    // Methods
    //--------------------------------------------

    // %%% --- Implement Sluggable Interface ---

    public function sluggableFields() : array
    {
        return ['aname'];
    }

    // %%% --- Implement Selectable Interface ---

    public static function getSelectOptions($includeBlank=true, $keyField='id', $filters=[]) : array
    {
        $records = self::all();
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }
        foreach ($records as $i => $r) {
            $options[$r->{$keyField}] = $r->aname;
        }
        return $options;
    }
}
