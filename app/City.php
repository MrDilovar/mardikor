<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function applicant()
    {
        return $this->hasOne('App\Applicant');
    }

    public function employer()
    {
        return $this->hasOne('App\Employer');
    }

    public function vacancy()
    {
        return $this->hasOne('App\Vacancy');
    }
}
