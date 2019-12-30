<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantSkill extends Model
{
    protected $guarded = [
        'id'
    ];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant');
    }
}
