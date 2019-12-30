<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mardikor extends Model
{
    protected $guarded = [
        'id'
    ];

    public function get_created_at()
    {
        return $this->updated_at->day . ' ' . Month::find($this->updated_at->month)->name . ' ' . $this->updated_at->format('H:i');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
