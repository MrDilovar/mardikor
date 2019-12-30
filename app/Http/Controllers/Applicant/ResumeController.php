<?php

namespace App\Http\Controllers\Applicant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Specialization;
use App\Resume;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Gate;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resumes = Auth::user()->data->resumes;

        $resumes->map(function ($resume, $key) {
            $resume->birthday = Carbon::now()->year - (new Carbon($resume->applicant->birthday))->year;
            $resume->date = Carbon::parse($resume->updated_at)->format('d.m.y, H:i');
            $resume->photo = '/' .  self::PATH_TO_APPLICANT_PHOTO . $resume->applicant->photo;
            return $resume;
        });

        $job_experiences = Auth::user()->data->job_experiences;
        $job_experiences_to_month = 0;

        foreach ($job_experiences as $experience) {
            $job_experiences_to_month += Carbon::parse($experience->end_job)->diffInMonths(Carbon::parse($experience->begin_job));
        }

        $job_experience_month = $job_experiences_to_month % 12;
        $job_experience_year = ($job_experiences_to_month - ($job_experience_month % 12))/12;

        return view('applicant.resume.index', [
            'resumes'=>$resumes,
            'job_experience_month'=>$job_experience_month,
            'job_experience_year'=>$job_experience_year
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specializations = Specialization::all();

        return view('applicant.resume.create', ['specializations'=>$specializations]);
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
            'title'=>'required|max:255',
            'salary'=> !is_null($request->salary) ? 'integer|max:90000' : '',
            'specialization_id'=>'required|not_in:0',
        ]);

        $data = $request->except(['_token']);
        $data['applicant_id'] = Auth::user()->data->id;
        $resume = new Resume($data);
        $resume->save();

        return redirect(route('applicant.resume.index'))->with('success', 'Резюме была добавлено!');
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
        $specializations = Specialization::all();
        $resume = Resume::findOrFail($id);

        return view('applicant.resume.edit', ['resume'=>$resume, 'specializations'=>$specializations]);
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
            'title'=>'required|max:255',
            'salary'=> !is_null($request->salary) ? 'integer|max:90000' : '',
            'specialization_id'=>'required|not_in:0',
        ]);

        $resume = Resume::findOrFail($id);

        if (Gate::denies('applicant_can', $resume->applicant->id))
            return redirect(route('applicant.resume.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $resume->title = $request->title;
        $resume->salary = $request->salary;
        $resume->specialization_id = $request->specialization_id;
        $resume->save();

        return redirect(route('applicant.resume.index'))->with('success', 'Резюме была изменено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resume = Resume::findOrFail($id);

        if (Gate::denies('applicant_can', $resume->applicant->id))
            return redirect(route('applicant.resume.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $resume->delete();

        return redirect()->back()->with('success', 'Резюме было удалено!');
    }
}
