<?php
namespace App\Archive;

use Illuminate\Database\Eloquent\Model;

class PersonFile extends Model
{
    protected $table = 'people_files';

    protected $fillable = ['type', 'related_id', 'filename','ext'];

    public $timestamps = false;

    public function camoLink()
    {
        return $this->belongsTo('App\Archive\CamoLink', 'related_id')->where('type', 2);
    }



}
