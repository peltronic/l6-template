<?php
namespace App\Models;

interface Nameable {

    // Returns a name representing the Model object eg... 
    //   User -> username
    //   Widget -> wname
    //   default ->  guid or slug
    public function renderName() : string;

}
