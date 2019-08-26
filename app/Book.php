<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //---MXV Attrs que son asignados masivo, osea que se pueden llenar
    protected $fillable = [
        'name','author'
    ];
}
