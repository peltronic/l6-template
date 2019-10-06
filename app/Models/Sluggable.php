<?php
namespace App\Models;

interface Sluggable {

    // Returns array of column names to use to create slug
    public function sluggableFields() : array;

}
