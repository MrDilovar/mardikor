<?php

namespace App\Http\Controllers\Applicant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HigherEducation;
use Carbon\Carbon;
use App\EducationStatus;
use Auth;
use Illuminate\Support\Facades\Gate;

class EducationHigherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $higher_educations = Auth::user()->data->higher_educations;

        return view('applicant.higher_education.index', ['higher_educations'=>$higher_educations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_yer = Carbon::now()->year;
        $education_statuses = EducationStatus::all();

        return view('applicant.higher_education.create', ['current_yer'=>$current_yer, 'education_statuses'=>$education_statuses]);
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
            'country'=>'required|max:255',
            'city'=>'required|max:255',
            'university'=>'required|max:255',
            'chair'=>'required|max:255',
            'education_status_id'=>'required|integer|not_in:0',
            'graduation'=>'required|integer|not_in:0|max:2050',
        ]);

        $data = $request->except(['_token']);
        $data['applicant_id'] = Auth::user()->data->id;

        HigherEducation::create($data);

        return redirect(route('applicant.education.higher.index'))->with('success', 'Образования была добавлено!');
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
        $higher_education = HigherEducation::findOrFail($id);
        $current_yer = Carbon::now()->year;
        $education_statuses = EducationStatus::all();

        return view('applicant.higher_education.edit', ['higher_education'=>$higher_education, 'current_yer'=>$current_yer, 'education_statuses'=>$education_statuses]);
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
            'country'=>'required|max:255',
            'city'=>'required|max:255',
            'university'=>'required|max:255',
            'chair'=>'required|max:255',
            'education_status_id'=>'required|integer|not_in:0',
            'graduation'=>'required|integer|not_in:0|max:2050',
        ]);

        $higher_education = HigherEducation::findOrFail($id);

        if (Gate::denies('applicant_can', $higher_education->applicant->id))
            return redirect(route('applicant.education.higher.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $higher_education->fill($request->all())->save();

        return redirect(route('applicant.education.higher.index'))->with('success', 'Образования была изменено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $higher_education = HigherEducation::findOrFail($id);

        if (Gate::denies('applicant_can', $higher_education->applicant->id))
            return redirect(route('applicant.education.higher.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $higher_education->delete();

        return redirect()->back()->with('success', 'Образования было удалено!');
    }
}
