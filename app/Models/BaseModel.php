<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Utils\ModelTraits;
//use App\Libs\Utils\Guid;
use App\Libs\Utils\ViewHelpers;

// %TODO: get rid of base model, use interfaces & traits (???)

// %TODO: consider turning this into a package, and trait instead of a class, and then models
// use it instead of extend it
class BaseModel extends Model implements Nameable, FieldRenderable
{
    public static $vrules = []; // override in child class (%FIXME: better to make protected & expose this as a method??)
    // Be sure to access using late static binding!

    use ModelTraits;

        /*
    public function scopeRecent($query) {
        return $query->orderBy('id', 'desc');
    }

    public function scopeOrdered($query) {
        return $query->orderBy('order', 'desc');
    }
         */

    //--------------------------------------------
    // Boot
    //--------------------------------------------
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if ( $model instanceOf Guidable ) {
                $model->guid = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
            }
            if ( $model instanceOf Sluggable ) {
                $sluggableFields = $model->sluggableFields(); //['string'=>'aname'];
                $model->slug = $model->slugify($sluggableFields);
            }
        });
    }

    // %%% --- Implement Collectable Interface (default,  sublcasses may override) ---

    public function renderName() : string 
    {
        if ( $this instanceof Sluggable ) {
            return $this->slug;
        } else if ( $this instanceof Guidable ) {
            return $this->guid;
        } else {
            // should not really be using this...except for dev
            // %TODO: throw an error?
            return $this->id;
        }
    }

    // %%% --- Model Traits Overrides  ---

    // child classes can override, but impl should call parent
    public function renderField(string $field) : ?string
    {
        $key = trim($field);
        switch ($key) {
            case 'guid':
                //return strtoupper($this->{$field});
                return strtoupper(substr($this->{$field},0,8));
            case 'created_at':
            case 'updated_at':
            case 'deleted_at':
                // %FIXME: this breaks guid when used as object resource in link_to_route()
                return ViewHelpers::makeNiceDate($this->{$field},1,1); // number format, include time
            default:
                return $this->{$field};
        }
    }

    // Model -name- to slug (was toSlug)
    public static function slugifyModel() : string
    {
        // default implemenation, override as needed
        $s = strtolower(static::class);
        return substr( strrchr( $s, '\\' ), 1 );
    }

}
