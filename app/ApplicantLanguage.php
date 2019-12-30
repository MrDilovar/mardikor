<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ApplicantLanguage extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    public static function is_unique_language($language_id, $language_level_id)
    {
        return self::where('applicant_id', Auth::user()->data->id)
            ->where('language_id', $language_id)
            ->where('language_level_id', $language_level_id)
            ->get()
            ->isEmpty();
    }

    public function language()
    {
        return $this->belongsTo('App\Language');
    }

    public function language_level()
    {
        return $this->belongsTo('App\LanguageLevel');
    }

    public function applicant()
    {
        return $this->belongsTo('App\Applicant');
    }
}
