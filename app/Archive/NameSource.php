<?php

namespace App\Archive;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class NameSource extends Model
{
    protected $guarded = ['person_id', 'files', 'sourceUploadFiles'];

    public $timestamps = false;

    public static function getTypes()
    {
        return DB::table('name_source_types')->get();
    }

    // accessors

    public function getTypeAttribute()
    {
        return DB::table('name_source_types')
            ->select('name')
            ->where('id', '=', $this->type_id)
            ->value('name');
    }

    // relations

    public function person()
    {
        return $this->belongsTo('App\Archive\Person');
    }

    public function files()
    {
        return $this->hasMany('App\Archive\PersonFile', 'related_id')->where('type', 2);
    }

}
