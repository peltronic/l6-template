<?php

namespace App\Models;

class Account extends Model
{
    protected $fillable = [' guid', 'slug', 'user_id', 'aname', 'adesc', 'jsonattrs'];
}
