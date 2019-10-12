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

    // %TODO: trait + interface Filterable
    public function scopeFiltered($query, array $filters=[])
    {
        if ( array_key_exists('aname', $filters) ) {
            $query->where('aname', 'like', '%'.$filters['aname'].'%');
        }
        return $query;
    }

    // %TODO: trait + interface Sortable
    public function scopeOrdered($query, array $sorter=[])
    {
        $sort_on = $sorter['sort_on'];
        $sort_direction = array_key_exists('is_sort_asc', $sorter)
            ? ($sorter['is_sort_asc'] ? 'asc' : 'desc')
            : 'asc'; // default is asc
        $query->orderBy($sort_on, $sort_direction);
        return $query;
    }

    // $searcher can be array or string
    public function scopeSearched($query, $searcher=null)
    {
        if ( is_array($searcher) ) {
            $str = array_key_exists('value', $searcher) ? $searcher['value'] : null;
        } else if ( is_string($searcher) ) {
            $str = $searcher;
        } else {
            $str = null;
        }
        if ( !empty($str) && is_string($str) ) {
            $query->where( function ($q) use($str) {
                $q->where('slug', 'like', '%'.$str.'%');
                $q->orWhere('guid', 'like', $str.'%');
                $q->orWhere('aname', 'like', $str.'%');
            });
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
