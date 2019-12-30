<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Negotiation extends Model
{
    protected $guarded = [
        'id'
    ];

    public function resume()
    {
        return $this->belongsTo('App\Resume');
    }

    public function vacancy()
    {
        return $this->belongsTo('App\Vacancy');
    }

    public function status()
    {
        return $this->belongsTo('App\NegotiationStatus');
    }

    public function hasStatus($status = null)
    {
        switch ($status) {
            case 'discard':
                $get_status = 4;
                break;
            case 'invite':
                $get_status = 3;
                break;
            case 'viewed':
                $get_status = 2;
                break;
            default:
                $get_status = 1;
        }

        return $this->status->id == $get_status;
    }
}
