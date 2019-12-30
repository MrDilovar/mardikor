<?php

namespace App\Http\Controllers\Employer;

use App\Month;
use App\Negotiation;
use App\NegotiationStatus;
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

        foreach (Auth::user()->data->vacancies as $vacancy) {
            if (!$vacancy->negotiations->isEmpty()) {
                foreach ($vacancy->negotiations as $negotiation) {
                    $negotiation->date = $negotiation->updated_at->format('j ' . Month::find($negotiation->updated_at->month)->name . ' Y');
                }

                $negotiations->push($vacancy->negotiations);
            }
        }

        $negotiations = $negotiations->collapse()->sortByDesc('updated_at');
        $negotiation_statuses = NegotiationStatus::all();

        return view('employer.negotiation.index', ['negotiations'=>$negotiations, 'negotiation_statuses'=>$negotiation_statuses]);

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

        if (Gate::denies('employer_can', $negotiation->vacancy->employer->id))
            return redirect(route('employer.negotiations.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        if ($negotiation->status_id == 1) {
            $negotiation->status_id = 2;
            $negotiation->resume_notification = 'on';
        }

        $negotiation->vacancy_notification = 'off';
        $negotiation->save();
        $negotiation->date = $negotiation->created_at->format('j ' . Month::find($negotiation->created_at->month)->name . ' Y');
        $negotiation->employer_date = $negotiation->updated_at->format('j ' . Month::find($negotiation->updated_at->month)->name . ' Y');

        return view('employer.negotiation.show', ['negotiation'=>$negotiation]);
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

        if (Gate::denies('employer_can', $negotiation->vacancy->employer->id))
            return redirect(route('employer.negotiations.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        $negotiation->delete();

        return redirect()->back()->with('success', 'Отклик было удалено!');
    }

    public function respond_show($id)
    {
        $resume = Resume::findOrFail($id);
        $vacancies = Auth::user()->data->vacancies;

        $respond = true;
        $allows_vacancies = collect();

        foreach ($vacancies as $vacancy) {
            $negotiation = Negotiation::where('resume_id', $id)->where('vacancy_id', $vacancy->id)->first();
            if (is_null($negotiation)) {
                $allows_vacancies->push($vacancy);
                $respond = false;
            }
        }

        if ($respond) return redirect()->route('employer.negotiation.show', $negotiation->id);

        return view('employer.negotiation.respond_show', [
            'resume'=>$resume,
            'vacancies'=>$vacancies,
            'allows_vacancies'=>$allows_vacancies
        ]);
    }

    public function respond_store(Request $request, $id)
    {
        $request->validate([
            'vacancy_id'=>'required|integer',
            'letter'=>'max:1000',
        ]);

        $vacancy = Vacancy::findOrFail($request->vacancy_id);

        if (Gate::denies('employer_can', $vacancy->employer->id))
            return redirect(route('guest.resume', $id))->with('success', 'У вас нет прав для выполнения данного действия!');

        $respond = true;
        foreach (Auth::user()->data->vacancies as $vacancy) {
            $negotiation = Negotiation::where('resume_id', $id)->where('vacancy_id', $vacancy->id)->first();
            if (is_null($negotiation)) {
                $respond = false;
                break;
            }
        }

        if ($respond) return redirect()->route('employer.negotiation.show', $negotiation->id);


        Negotiation::create([
            'resume_id'=>$id,
            'vacancy_letter'=>$request->letter,
            'vacancy_id'=>$request->vacancy_id,
            'vacancy_notification'=>'off',
            'status_id'=>3
        ]);

        return redirect(route('guest.resume', $id))->with('success', 'Вакансия доставлено!');
    }

    public function cancel($id)
    {
        $negotiation = Negotiation::findOrFail($id);

        if (Gate::denies('employer_can', $negotiation->vacancy->employer->id))
            return redirect(route('employer.negotiations.index'))->with('success', 'У вас нет прав для выполнения данного действия!');

        if ($negotiation->status_id == 3 || $negotiation->status_id == 4 )
        {
            $status = $negotiation->status->name;
            $negotiation->status_id = 2;
            $negotiation->vacancy_letter = null;
            $negotiation->resume_notification = 'on';
            $negotiation->vacancy_notification = 'on';
            $negotiation->save();
            return redirect()->back()->with('success', $status . ' было отменено!');
        }

        return redirect()->back();
    }

    public function discard_show($id)
    {
        $negotiation = Negotiation::findOrFail($id);

        if (Gate::denies('employer_can', $negotiation->vacancy->employer->id))
            return redirect(route('employer.negotiations.index'))
                ->with('success', 'У вас нет прав для выполнения данного действия!');

        $negotiation->date = $negotiation->created_at->format('j ' . Month::find($negotiation->created_at->month)->name . ' Y');

        return view('employer.negotiation.discard_show', ['negotiation'=>$negotiation]);
    }

    public function discard_store(Request $request, $id)
    {
        $negotiation = Negotiation::findOrFail($id);

        if (Gate::denies('employer_can', $negotiation->vacancy->employer->id))
            return redirect(route('employer.negotiations.index'))
                ->with('success', 'У вас нет прав для выполнения данного действия!');

        $negotiation->status_id = 4;
        $negotiation->vacancy_letter = $request->letter;
        $negotiation->resume_notification = 'on';
        $negotiation->vacancy_notification = 'off';
        $negotiation->save();

        return redirect(route('employer.negotiation.index'))->with('success', 'Отклик отправлено!');
    }

    public function invite_show($id)
    {
        $negotiation = Negotiation::findOrFail($id);

        if (Gate::denies('employer_can', $negotiation->vacancy->employer->id))
            return redirect(route('employer.negotiations.index'))
                ->with('success', 'У вас нет прав для выполнения данного действия!');

        $negotiation->date = $negotiation->created_at->format('j ' . Month::find($negotiation->created_at->month)->name . ' Y');

        return view('employer.negotiation.invite_show', ['negotiation'=>$negotiation]);
    }

    public function invite_store(Request $request, $id)
    {
        $negotiation = Negotiation::findOrFail($id);

        if (Gate::denies('employer_can', $negotiation->vacancy->employer->id))
            return redirect(route('employer.negotiations.index'))
                ->with('success', 'У вас нет прав для выполнения данного действия!');

        $negotiation->status_id = 3;
        $negotiation->vacancy_letter = $request->letter;
        $negotiation->resume_notification = 'on';
        $negotiation->vacancy_notification = 'off';
        $negotiation->save();

        return redirect(route('employer.negotiation.index'))->with('success', 'Отклик отправлено!');
    }
}
