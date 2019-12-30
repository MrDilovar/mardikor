<?php

namespace App\Http\Controllers\Applicant;

use App\SecondaryEducation;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class EducationSecondaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $secondary_educations = Auth::user()->data->secondary_educations;

        return view('applicant.secondary_education.index', ['secondary_educations'=>$secondary_educations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_yer = Carbon::now()->year;

        return view('applicant.secondary_education.create', ['current_yer'=>$current_yer]);
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
            'study_start'=>'required|integer|not_in:0|max:2050',
            'study_finish'=>'required|integer|not_in:0|max:2050',
            'school'=>'required|max:255',
            'city'=>'required|max:255',
            'country'=>'required|max:255',
        ]);

        $data = $request->except(['_token']);
        $data['applicant_id'] = Auth::user()->data->id;

        SecondaryEducation::create($data);

        return redirect(route('applicant.education.secondary.index'))->with('success', 'Образования была добавлено!');
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
        $secondaryEducation = SecondaryEducation::findOrFail($id);
        $current_yer = Carbon::now()->year;

        return view('applicant.secondary_education.edit', ['secondaryEducation'=>$secondaryEducation, 'current_yer'=>$current_yer]);
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
            'study_start'=>'required|integer|not_in:0|max:2050',
            'study_finish'=>'required|integer|not_in:0|max:2050',
            'school'=>'required|max:255',
            'city'=>'required|max:255',
            'country'=>'required|max:255',
        ]);

        $secondary_education = SecondaryEducation::findOrFail($id);

        if (Gate::denies('applicant_can', $secondary_education->applicant->id))
            return redirect(route('applicant.education.secondary.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $secondary_education->fill($request->all())->save();

        return redirect(route('applicant.education.secondary.index'))->with('success', 'Образования была изменено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $secondary_education = SecondaryEducation::findOrFail($id);

        if (Gate::denies('applicant_can', $secondary_education->applicant->id))
            return redirect(route('applicant.education.secondary.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $secondary_education->delete();

        return redirect()->back()->with('success', 'Образования было удалено!');
    }
}
