<?php

namespace App\Http\Controllers\Applicant;

use App\ApplicantSkill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Gate;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Auth::user()->data->skills;

        return view('applicant.skill.index', ['skills'=>$skills]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('applicant.skill.create');
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
        ]);

        $data = $request->all();
        $data['applicant_id'] = Auth::user()->data->id;
        ApplicantSkill::create($data);

        return redirect(route('applicant.skill.index'))->with('success', 'Навык была добавлено!');
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
        $skill = ApplicantSkill::findOrFail($id);

        return view('applicant.skill.edit', ['skill'=>$skill]);
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
        ]);

        $applicant_skill = ApplicantSkill::findOrFail($id);

        if (Gate::denies('applicant_can', $applicant_skill->applicant->id))
            return redirect(route('applicant.skill.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $applicant_skill->fill($request->all())->save();

        return redirect(route('applicant.skill.index'))->with('success', 'Навык была изменено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $applicant_skill = ApplicantSkill::findOrFail($id);

        if (Gate::denies('applicant_can', $applicant_skill->applicant->id))
            return redirect(route('applicant.skill.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $applicant_skill->delete();

        return redirect()->back()->with('success', 'Навык было удалено!');
    }
}
