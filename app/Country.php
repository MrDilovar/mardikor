<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function applicant()
    {
        return $this->hasOne('App\Applicant');
    }
}
