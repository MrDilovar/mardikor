<?php

namespace App\Http\Controllers\Guest;

use App\Employer;
use App\Http\Controllers\Applicant\ApplicantController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Employer\EmployerController;
use App\Month;
use App\Negotiation;
use App\Resume;
use App\Specialization;
use App\Vacancy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    public function home()
    {
        if (Gate::allows('is_applicant')) return (new ApplicantController)->home();

        if (Gate::allows('is_employer')) return (new EmployerController())->home();

        $specializations = Specialization::orderBy('name')->get();
        $vacancies = Vacancy::orderBy('id')->get();
        $employers = Employer::orderBy('brand')->get();

        foreach ($specializations as $specialization) {
            $specialization->vacancies = Vacancy::where('specialization_id', $specialization->id)->count();
            $specialization->resumes = Resume::where('specialization_id', $specialization->id)->count();
        }

        foreach ($employers as $employer) {
            $employer->vacancies = Vacancy::where('employer_id', $employer->id)->count();
        }

        $resumes = Resume::all()->reverse();
        $resumes->map(function ($resume, $key) {
            $resume->birthday = Carbon::now()->year - (new Carbon($resume->applicant->birthday))->year;
            $resume->date = Carbon::parse($resume->updated_at)->format('d.m.y, H:i');
            $resume->photo = '/' .  self::PATH_TO_APPLICANT_PHOTO . $resume->applicant->photo;

            $job_experiences = $resume->applicant->job_experiences;
            $job_experiences_to_month = 0;

            foreach ($job_experiences as $experience) {
                $job_experiences_to_month += Carbon::parse($experience->end_job)->diffInMonths(Carbon::parse($experience->begin_job));
            }

            $resume->experience_month = $job_experiences_to_month % 12;
            $resume->experience_year = ($job_experiences_to_month - ($resume->experience_month % 12))/12;
            return $resume;
        });

        return view('guest.home', [
            'specializations'=>$specializations,
            'vacancies'=>$vacancies,
            'resumes'=>$resumes,
            'employers'=>$employers,
        ]);
    }

    public function vacancy($id)
    {
        $vacancy = Vacancy::findOrFail($id);

        if (Gate::allows('is_applicant')) {
            $negotiations = collect();

            foreach (Auth::user()->data->resumes as $resume) {
                if (!$resume->negotiations->isEmpty())
                    $negotiations->push($resume->negotiations);
            }

            $vacancy->negotiation = $negotiations->collapse()->firstWhere('vacancy_id', $id);
        }

        $vacancy->date = $vacancy->created_at->format('j ' . Month::find($vacancy->created_at->month)->name . ' Y');

        return view('guest.vacancy', ['vacancy'=>$vacancy, 'PATH_TO_EMPLOYER_PHOTO'=>self::PATH_TO_EMPLOYER_PHOTO]);
    }

    public function resume($id)
    {
        $resume = Resume::findOrFail($id);

        if (Gate::allows('is_employer')) {
            $respond = true;
            foreach (Auth::user()->data->vacancies as $vacancy) {
                $negotiation = Negotiation::where('vacancy_id', $vacancy->id)->where('resume_id', $resume->id)->first();
                if (is_null($negotiation)) {
                    $respond = false;
                    break;
                }
            }

            if ($respond) $resume->negotiation = $resume->negotiations->firstWhere('vacancy_id', Auth::user()->data->vacancies->last()->id);
        }

        $applicant = $resume->applicant;
        $applicant->birthday = Carbon::parse($applicant->birthday)->format('d.m.Y');
        $applicant->path_photo = '/' . self::PATH_TO_APPLICANT_PHOTO . $applicant->photo;

        return view('guest.resume', ['resume'=>$resume, 'applicant'=>$applicant]);
    }

    public function employer($id)
    {
        $employer = Employer::findOrFail($id);
        return view('guest.employer', [
            'employer'=>$employer,
            'PATH_TO_EMPLOYER_PHOTO'=>self::PATH_TO_EMPLOYER_PHOTO
        ]);
    }

    public function echo()
    {
        function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        function get0($zero_bytes_count, $length_random_string) {
            $search = '';
            for ($i = 0; $i < $zero_bytes_count; $i++) $search .= '0';

            $count = 0;
            $find = 0;
            $last_poz = 0;
            $sum_poz = 0;
            for ($i = 0; $i < 1000000; $i++) {
                $random_string = generateRandomString($length_random_string);
                $res_hash = hash("sha256", $random_string);

                if (substr($res_hash, 0, $zero_bytes_count)=== $search) {
                    $find += $i;
                    $count++;
                    $sum_poz += $i - $last_poz;
                    dump($count . ' | ' . 'Позиция хеша: ' . $i . ' | Хеш: ' . $res_hash);
                }

                if ($count === 1000) return $search . ': ' . $sum_poz/1000;
            }

            return 'End.';
        }



        dump(get0(1, 20));

        return;
    }
}
