<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecondaryEducation extends Model
{
    protected $guarded = [
        'id'
    ];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant');
    }
}
