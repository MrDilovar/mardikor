<?php

namespace App\Http\Controllers\Applicant;

use App\Applicant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\JobExperience;
use Auth;
use App\Month;
use Illuminate\Support\Facades\Gate;

class JobExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $months = Month::all()->sortBy('id');
        $job_experiences = Auth::user()->data->job_experiences;
        $job_experiences_to_month = 0;

        foreach ($job_experiences as $job_experience) {
            $begin_job = Carbon::parse($job_experience->begin_job);
            $job_experience->begin_job_month = $months[$begin_job->month]->name;
            $job_experience->begin_job_year = $begin_job->year;

            $end_job = Carbon::parse($job_experience->end_job);
            $job_experience->end_job_month = $months[$end_job->month]->name;
            $job_experience->end_job_year = $end_job->year;

            $job_experiences_to_month += $end_job->diffInMonths($begin_job);
        }

        $job_experiences->month = $job_experiences_to_month % 12;
        $job_experiences->year = ($job_experiences_to_month - ($job_experiences->month % 12))/12;

        return view('applicant.job_experience.index', ['job_experiences'=>$job_experiences]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $months = Month::all()->sortBy('id');
        $current_yer = Carbon::now()->year;
        return view('applicant.job_experience.create', ['months'=>$months, 'current_yer'=>$current_yer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'begin_month'=>'required|not_in:0',
            'begin_yer'=>'required|not_in:0',
            'end_month'=>'required|not_in:0',
            'end_yer'=>'required|not_in:0',
            'company_name'=>'required|max:255',
            'position'=>'required|max:255',
            'description'=>'required|max:1000',
        ]);

        $begin_job = Carbon::create($request->begin_yer, $request->begin_month, 1)->format('Y-m-d');
        $end_job = Carbon::create($request->end_yer, $request->end_month, 1)->format('Y-m-d');

        $job_experience = new JobExperience();
        $job_experience->applicant_id = Auth::user()->data->id;
        $job_experience->begin_job = $begin_job;
        $job_experience->end_job = $end_job;
        $job_experience->company_name = $request->company_name;
        $job_experience->position = $request->position;
        $job_experience->description = $request->description;
        $job_experience->save();

        $this->update_applicant_job_experience();

        return redirect(route('applicant.experience.index'))->with('success', 'Опыт работы была добавлено!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job_experience = JobExperience::findOrFail($id);
        $job_experience->begin_job = Carbon::parse($job_experience->begin_job);
        $job_experience->end_job = Carbon::parse($job_experience->end_job);

        $months = Month::all()->sortBy('id');
        $current_yer = Carbon::now()->year;
        return view('applicant.job_experience.edit', ['job_experience'=>$job_experience,'months'=>$months, 'current_yer'=>$current_yer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'begin_month'=>'required|not_in:0',
            'begin_yer'=>'required|not_in:0',
            'end_month'=>'required|not_in:0',
            'end_yer'=>'required|not_in:0',
            'company_name'=>'required|max:255',
            'position'=>'required|max:255',
            'description'=>'required|max:1000',
        ]);

        $begin_job = Carbon::create($request->begin_yer, $request->begin_month, 1)->format('Y-m-d');;
        $end_job = Carbon::create($request->end_yer, $request->end_month, 1)->format('Y-m-d');;

        $job_experience = JobExperience::findOrFail($id);

        if (Gate::denies('applicant_can', $job_experience->applicant->id))
            return redirect(route('applicant.experience.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $job_experience->begin_job = $begin_job;
        $job_experience->end_job = $end_job;
        $job_experience->company_name = $request->company_name;
        $job_experience->position = $request->position;
        $job_experience->description = $request->description;
        $job_experience->save();

        $this->update_applicant_job_experience();

        return redirect(route('applicant.experience.index'))->with('success', 'Опыт работы была изменено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job_experience = JobExperience::findOrFail($id);

        if (Gate::denies('applicant_can', $job_experience->applicant->id))
            return redirect(route('applicant.experience.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $job_experience->delete();

        $this->update_applicant_job_experience();

        return redirect()->back()->with('success', 'Опыт работы было удалено!');
    }

    private function update_applicant_job_experience()
    {
        $applicant = Auth::user()->data;
        $job_experiences_to_month = 0;

        foreach ($applicant->job_experiences as $experience)
            $job_experiences_to_month += Carbon::parse($experience->end_job)->diffInMonths(Carbon::parse($experience->begin_job));

        $job_experiences = $job_experiences_to_month/12;

        if ($job_experiences > 0 && $job_experiences < 3) $applicant->vacancy_experience_id = 2;
        elseif ($job_experiences >= 3 && $job_experiences < 6) $applicant->vacancy_experience_id = 3;
        elseif ($job_experiences >= 6) $applicant->vacancy_experience_id = 4;
        else $applicant->vacancy_experience_id = 1;

        $applicant->save();
    }
}
