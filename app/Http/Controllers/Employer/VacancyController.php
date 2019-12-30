<?php

namespace App\Http\Controllers\Employer;

use App\City;
use App\VacancyExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Specialization;
use App\Vacancy;
use Auth;


class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employer.vacancy.index', ['vacancies'=>Auth::user()->data->vacancies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vacancy_experiences = VacancyExperience::all();
        $cities = City::all();
        $specializations = Specialization::all();
        return view(
            'employer.vacancy.create',
            [
                'specializations'=>$specializations,
                'cities'=>$cities,
                'vacancy_experiences'=>$vacancy_experiences,
            ]
        );
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
            'name'=>'required|max:255',
            'specialization_id'=>'required|integer|not_in:0',
            'city_id'=>'required|integer|not_in:0',
            'vacancy_experience_id'=>'required|integer|not_in:0',
        ]);

        if ($request->has('compensation_from_visible') && $request->compensation_from_visible) {
            $request->validate([
                'compensation_from_visible'=>'integer|max:90000',
            ]);
        }

        if ($request->has('compensation_to_visible') && $request->compensation_to_visible) {
            $request->validate([
                'compensation_to_visible'=>'integer|max:90000',
            ]);

            if ($request->compensation_to_visible - $request->compensation_from_visible <= 0) {
                $request->merge(['compensation_to_visible'=>null]);
            }
        }

        $data = $request->except(['_token']);
        $data['employer_id'] = Auth::user()->data->id;
        $vacancy = new Vacancy($data);
        $vacancy->save();

        return redirect(route('employer.vacancy.index'))->with('success', 'Вакансия была добавлено!');
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
        $vacancy = Vacancy::findOrFail($id);
        $vacancy_experiences = VacancyExperience::all();
        $cities = City::all();
        $specializations = Specialization::all();

        return view(
            'employer.vacancy.edit',
            [
                'vacancy'=>$vacancy,
                'cities'=>$cities,
                'specializations'=>$specializations,
                'vacancy_experiences'=>$vacancy_experiences
            ]
        );
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
            'name'=>'required|max:255',
            'specialization_id'=>'required|integer|not_in:0',
            'city_id'=>'required|integer|not_in:0',
            'vacancy_experience_id'=>'required|integer|not_in:0',
        ]);

        if ($request->has('compensation_from_visible') && $request->compensation_from_visible) {
            $request->validate([
                'compensation_from_visible'=>'integer|max:90000',
            ]);
        }

        if ($request->has('compensation_to_visible') && $request->compensation_to_visible) {
            $request->validate([
                'compensation_to_visible'=>'integer|max:90000',
            ]);

            if ($request->compensation_to_visible - $request->compensation_from_visible <= 0) {
                $request->merge(['compensation_to_visible'=>null]);
            }
        }

        Vacancy::findOrFail($id)->fill($request->all())->save();

        return redirect(route('employer.vacancy.index'))->with('success', 'Вакансия была обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vacancy = Vacancy::findOrFail($id);

        if (Gate::denies('employer_can', $vacancy->employer->id))
            return redirect(route('employer.vacancy.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $vacancy->delete();

        return redirect()->back()->with('success', 'Вакансия было удалено!');
    }
}
