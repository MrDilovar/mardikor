<?php

namespace App\Http\Controllers\Applicant;

use App\Month;
use App\Negotiation;
use App\Resume;
use App\Vacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NegotiationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $negotiations = collect();

        foreach (Auth::user()->data->resumes as $resume) {
            if (!$resume->negotiations->isEmpty()) {
                foreach ($resume->negotiations as $negotiation) {
                    $negotiation->date = $negotiation->created_at->format('j ' . Month::find($negotiation->created_at->month)->name . ' Y');
                }

                $negotiations->push($resume->negotiations);
            }
        }

        $negotiations = $negotiations->collapse()->sortByDesc('updated_at');

        return view('applicant.negotiation.index', ['negotiations'=>$negotiations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $negotiation = Negotiation::findOrFail($id);

        if (Gate::denies('applicant_can', $negotiation->resume->applicant->id))
            return redirect(route('applicant.negotiations.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $negotiation->resume_notification = 'off';
        $negotiation->save();
        $negotiation->date = $negotiation->created_at->format('j ' . Month::find($negotiation->created_at->month)->name . ' Y');
        $negotiation->employer_date = $negotiation->updated_at->format('j ' . Month::find($negotiation->updated_at->month)->name . ' Y');

        return view('applicant.negotiation.show', ['negotiation'=>$negotiation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $negotiation = Negotiation::findOrFail($id);

        if (Gate::denies('applicant_can', $negotiation->resume->applicant->id))
            return redirect(route('applicant.negotiation.index'))
                ->with('success', 'У вас нет прав для выполнения данного действия!');

        $negotiation->delete();

        return redirect()->back()->with('success', 'Отклик было удалено!');
    }

    public function respond_show($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $resumes = Auth::user()->data->resumes;

        foreach ($resumes as $resume) {
            $negotiation = Negotiation::where('vacancy_id', $id)->where('resume_id', $resume->id)->first();
            if (!is_null($negotiation))
                return redirect()->route('applicant.negotiation.show', $negotiation->id);
        }

        return view('applicant.negotiation.respond_show', ['vacancy'=>$vacancy, 'resumes'=>$resumes]);
    }

    public function respond_store(Request $request, $id)
    {
        $request->validate([
            'resumeId'=>'required|integer',
            'letter'=>'max:1000',
        ]);

        $resume = Resume::findOrFail($request->resumeId);

        if (Gate::denies('applicant_can', $resume->applicant->id))
            return redirect(route('guest.vacancy', $id))->with('success', 'У вас нет прав для выполнения данного действия!');

        $negotiation = Negotiation::where('vacancy_id', $id)->where('resume_id', $request->resumeId)->first();
        if (!is_null($negotiation))
            return redirect()->route('applicant.negotiation.show', $negotiation->id);

        Negotiation::create([
            'resume_id'=>$request->resumeId,
            'resume_letter'=>$request->letter,
            'vacancy_id'=>$id,
            'resume_notification'=>'off',
        ]);

        return redirect(route('guest.vacancy', $id))->with('success', 'Резюме доставлено!');
    }
}
