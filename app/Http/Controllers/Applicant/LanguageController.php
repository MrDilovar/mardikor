<?php

namespace App\Http\Controllers\Applicant;

use App\LanguageLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\ApplicantLanguage;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Auth::user()->data->languages;

        return view('applicant.language.index', ['languages'=>$languages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Language::all();
        $language_levels = LanguageLevel::all();

        return view('applicant.language.create', ['languages'=>$languages, 'language_levels'=>$language_levels]);
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
            'language_id'=>'required|integer|not_in:0',
            'language_level_id'=>'required|integer|not_in:0',
        ]);

        if (!ApplicantLanguage::is_unique_language($request->language_id, $request->language_level_id))
            return redirect(route('applicant.language.index'))->with('success', 'Этот язык уже было добавлен!');

        $data = $request->all();
        $data['applicant_id'] = Auth::user()->data->id;
        ApplicantLanguage::create($data);

        return redirect(route('applicant.language.index'))->with('success', 'Язык был добавлен!');
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
        $applicant_language = ApplicantLanguage::findOrFail($id);
        $languages = Language::all();
        $language_levels = LanguageLevel::all();

        return view('applicant.language.edit', ['applicant_language'=>$applicant_language, 'languages'=>$languages, 'language_levels'=>$language_levels]);
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
            'language_id'=>'required|integer|not_in:0',
            'language_level_id'=>'required|integer|not_in:0',
        ]);

        $applicant_language = ApplicantLanguage::findOrFail($id);

        if (Gate::denies('applicant_can', $applicant_language->applicant->id))
            return redirect(route('applicant.language.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        if (!ApplicantLanguage::is_unique_language($request->language_id, $request->language_level_id))
            return redirect(route('applicant.language.index'))->with('success', 'Этот язык уже было добавлен!');

        $applicant_language->fill($request->all())->save();

        return redirect(route('applicant.language.index'))->with('success', 'Язык была изменено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $applicant_language = ApplicantLanguage::findOrFail($id);

        if (Gate::denies('applicant_can', $applicant_language->applicant->id))
            return redirect(route('applicant.language.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $applicant_language->delete();

        return redirect()->back()->with('success', 'Язык было удалено!');
    }
}
