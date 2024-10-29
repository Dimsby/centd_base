<?php

namespace App\Archive;

use Illuminate\Database\Eloquent\Model;

class MemorialLink extends Model
{
    protected $guarded = ['available'];

    public function person()
    {
        return $this->belongsTo('App\Archive\Person');
    }
}
