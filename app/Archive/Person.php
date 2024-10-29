<?php

namespace App\Archive;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class Person extends Model
{
    public static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'found_date' => 'required'
    ];

    protected $guarded = ['source'];

    protected $appends = ['found_date_formatted', 'burial_date_formatted'];

    public static function boot()
    {
        parent::boot();

        self::creating(function (Person $person) {
            $person->author_id = Auth::id();
            \Cache::increment('totalPublishedPersons');
        });

        self::deleting(function (Person $person) {
            \Cache::decrement('totalPublishedPersons');
        });

        self::saving(function (Person $person) {
            if (isset($person->found_date)) {
                if ($person->found_date_type == 1)
                    $person->found_date = date('Y-m-d', strtotime($person->found_date));
                elseif ($person->found_date_type == 2)
                    $person->found_date = date('Y-m-d', strtotime('Jan ' . $person->found_date));
            }

            if (isset($person->burial_date)) {
                if ($person->burial_date_type == 1)
                    $person->burial_date = date('Y-m-d', strtotime($person->burial_date));
                elseif ($person->burial_date_type == 2)
                    $person->burial_date = date('Y-m-d', strtotime('Jan ' . $person->burial_date));
            }
        });
    }

    // accessors

    public function getMilitaryRankAttribute()
    {
        return DB::table('ranks')
            ->select('title')
            ->where('id', '=', $this->military_rank_id)
            ->value('title');
    }

    public function getFoundDateFormattedAttribute()
    {
        if (!$this->found_date)
            return false;

        if ($this->found_date_type == 1) {
            return date('m-Y', strtotime($this->found_date));
        } elseif ($this->found_date_type == 2) {
            return date('Y', strtotime($this->found_date));
        } else {
            return $this->found_date;
        }
    }

    public function getBurialDateFormattedAttribute()
    {
        if (!$this->burial_date)
            return false;

        if ($this->burial_date_type == 1) {
            return date('m-Y', strtotime($this->burial_date));
        } elseif ($this->burial_date_type == 2) {
            return date('Y', strtotime($this->burial_date));
        } else {
            return $this->burial_date;
        }
    }

    // relations

    public function camoLink()
    {
        return $this->hasOne('App\Archive\CamoLink');
    }

    public function memorialLink()
    {
        return $this->hasOne('App\Archive\MemorialLink');
    }

    public function exhumation()
    {
        return $this->hasOne('App\Archive\Exhumation');
    }

    public function immortalization()
    {
        return $this->hasOne('App\Archive\Immortalization');
    }

    public function nameSources()
    {
        return $this->hasMany('App\Archive\NameSource');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    // override

    public function delete()
    {
        $this->camoLink()->delete();
        $this->memorialLink()->delete();
        $this->nameSources()->delete();
        $this->exhumation()->delete();
        $this->immortalization()->delete();

        return parent::delete();
    }

}
