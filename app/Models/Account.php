<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Account extends BaseModel implements Selectable, Sluggable, Guidable, Filterable, Orderable, Searchable
{

    use OrderableTrait; // default implemenation for Filterable

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

    // Implementes Filterable
    public function scopeFiltered(Builder $query, array $filters=[]) : Builder
    {
        if ( array_key_exists('aname', $filters) ) {
            $query->where('aname', 'like', '%'.$filters['aname'].'%');
        }
        //dd( get_class($query));
        return $query;
    }

    // Implementes Searchable
    public function scopeSearched(Builder $query, $searcher=null) : Builder
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
