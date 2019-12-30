<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Resume extends Model
{
    protected $guarded = [
        'id'
    ];

    //is_employer
    public function responded()
    {
        foreach (Auth::user()->data->vacancies as $vacancy) {
            $negotiation = Negotiation::where('resume_id', $this->id)->where('vacancy_id', $vacancy->id)->first();

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

    public function applicant()
    {
        return $this->belongsTo('App\Applicant');
    }

    public function specialization()
    {
        return $this->belongsTo('App\Specialization');
    }

    public function negotiations()
    {
        return $this->hasMany('App\Negotiation');
    }
}
