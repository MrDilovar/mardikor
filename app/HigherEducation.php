<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HigherEducation extends Model
{
    protected $guarded = [
        'id'
    ];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant');
    }

    public function education_status()
    {
        return $this->belongsTo('App\EducationStatus');
    }
}
