<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                if (Gate::allows('is_applicant')) $this->set_notification_applicant();
                if (Gate::allows('is_employer')) $this->set_notification_employer();
            }

            return $next($request);
        });
    }

    const PATH_TO_APPLICANT_PHOTO = 'img/applicant/';
    const PATH_TO_EMPLOYER_PHOTO = 'img/employer/';

    private function set_notification_applicant()
    {
        $notifications = 0;

        foreach (Auth::user()->data->resumes as $resume) {
            if (!$resume->negotiations->isEmpty()) {
                foreach ($resume->negotiations as $negotiation) {
                    if ($negotiation->resume_notification == 'on')
                        $notifications++;
                }
            }
        }

        session(['notifications'=>$notifications]);
    }

    private function set_notification_employer()
    {
        $notifications = 0;

        foreach (Auth::user()->data->vacancies as $vacancy) {
            if (!$vacancy->negotiations->isEmpty()) {
                foreach ($vacancy->negotiations as $negotiation) {
                    if ($negotiation->vacancy_notification == 'on')
                        $notifications++;
                }
            }
        }

        session(['notifications'=>$notifications]);
    }
}
