<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Vacancy extends Model
{
    protected $guarded = [
        'id'
    ];

    //is_applicant
    public function responded()
    {
        foreach (Auth::user()->data->resumes as $resume) {
            $negotiation = Negotiation::where('vacancy_id', $this->id)->where('resume_id', $resume->id)->first();

            if (!is_null($negotiation)) {
                $this->responded = $negotiation;
                return true;
            }
        }

        return false;
    }

    public function get_created_at()
    {
        return $this->updated_at->day . ' ' . Month::find($this->updated_at->month)->name;
    }

    public function employer()
    {
        return $this->belongsTo('App\Employer');
    }

    public function negotiations()
    {
        return $this->hasMany('App\Negotiation');
    }

    public function specialization()
    {
        return $this->belongsTo('App\Specialization');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function vacancy_experience()
    {
        return $this->belongsTo('App\VacancyExperience');
    }
}
