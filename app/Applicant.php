<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'photo',
        'gender',
        'city_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function resumes()
    {
        return $this->hasMany('App\Resume');
    }

    public function secondary_educations()
    {
        return $this->hasMany('App\SecondaryEducation');
    }

    public function higher_educations()
    {
        return $this->hasMany('App\HigherEducation');
    }

    public function job_experiences()
    {
        return $this->hasMany('App\JobExperience');
    }

    public function vacancy_experience()
    {
        return $this->belongsTo('App\VacancyExperience');
    }

    public function skills()
    {
        return $this->hasMany('App\ApplicantSkill');
    }

    public function languages()
    {
        return $this->hasMany('App\ApplicantLanguage');
    }
}
