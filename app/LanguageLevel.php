<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LanguageLevel extends Model
{
    public function applicant_language()
    {
        return $this->hasOne('App\ApplicantLanguage');
    }
}
