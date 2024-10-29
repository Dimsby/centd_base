<?php

namespace App\Archive;

use Illuminate\Database\Eloquent\Model;

class Immortalization extends Model
{
    public $timestamps = false;

    protected $guarded = ['available'];

    public function person()
    {
        return $this->belongsTo('App\Archive\Person');
    }

}
