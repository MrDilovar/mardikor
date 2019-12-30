<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    public function resume()
    {
        return $this->hasOne('App\Resume');
    }

    public function vacancy()
    {
        return $this->hasOne('App\Vacancy');
    }
}
