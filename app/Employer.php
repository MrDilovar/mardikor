<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function vacancies()
    {
        return $this->hasMany('App\Vacancy');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
