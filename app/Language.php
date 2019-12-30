<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public function applicant_language()
    {
        return $this->hasOne('App\ApplicantLanguage');
    }
}
