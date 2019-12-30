<?php

namespace App\Http\Controllers\Guest;

use App\City;
use App\Resume;
use App\Specialization;
use App\VacancyExperience;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResumeController extends Controller
{
    public function __construct()
    {
        $this->salaries = collect(json_decode(json_encode($this->salaries), FALSE));
    }

    private $salaries = [
        ['id'=>'1', 'name'=> 'Указана', 'value'=>'0'],
        ['id'=>'2', 'name'=> 'от 1 000 сом.', 'value'=>'1000'],
        ['id'=>'3', 'name'=> 'от 2 000 сом.', 'value'=>'2000'],
        ['id'=>'4', 'name'=> 'от 3 000 сом.', 'value'=>'3000'],
    ];

    public function index(Request $request)
    {
        $specializations = Specialization::all();
        $cities = City::all();
        $vacancy_experiences = VacancyExperience::all();
        $resumes = $this->get_where_params()->orderByDesc('resumes.id')->paginate(10);
        $resumes->map(function ($resume) {
            $resume->birthday = Carbon::now()->year - (new Carbon($resume->applicant->birthday))->year;
            $resume->photo = '/' .  self::PATH_TO_APPLICANT_PHOTO . $resume->applicant->photo;
            $job_experiences = $resume->applicant->job_experiences;
            $job_experiences_to_month = 0;

            foreach ($job_experiences as $experience) {
                $job_experiences_to_month += Carbon::parse($experience->end_job)->diffInMonths(Carbon::parse($experience->begin_job));
            }

            $resume->experience_month = $job_experiences_to_month % 12;
            $resume->experience_year = ($job_experiences_to_month - ($resume->experience_month % 12))/12;
        });

        $selected_specialization = null;
        if (!is_null($request->specialization))
            $selected_specialization = $specializations->where('id', $request->specialization)->first();
        else
            foreach ($specializations as $specialization)
                $specialization->vacancies = $this->get_where_params(['specialization'=>$specialization->id])->count();

        $selected_city = null;
        if (!is_null($request->city))
            $selected_city = $cities->where('id', $request->city)->first();
        else
            foreach ($cities as $city)
                $city->vacancies = $this->get_where_params(['city'=>$city->id])->count();

        $selected_salary = null;
        if (!is_null($request->salary))
            $selected_salary = $this->salaries->where('id', $request->salary)->first();
        else
            foreach ($this->salaries as $salary)
                $salary->vacancies = $this->get_where_params(['salary'=>$salary->id])->count();

        $selected_vacancy_experience = null;
        if (!is_null($request->vacancy_experience))
            $selected_vacancy_experience = $vacancy_experiences->where('id', $request->vacancy_experience)->first();
        else
            foreach ($vacancy_experiences as $vacancy_experience)
                $vacancy_experience->vacancies = $this->get_where_params(['vacancy_experience'=>$vacancy_experience->id])->count();

        return view('guest.search_resume', [
            'specializations'=>$specializations->sortByDesc('vacancies'),
            'selected_specialization'=>$selected_specialization,
            'cities'=>$cities->sortByDesc('vacancies'),
            'selected_city'=>$selected_city,
            'salaries' => $this->salaries,
            'selected_salary'=>$selected_salary,
            'vacancy_experiences'=>$vacancy_experiences,
            'selected_vacancy_experience'=>$selected_vacancy_experience,
            'resumes'=>$resumes,

        ]);
    }

    private function get_where_params($old_params = [])
    {
        $resume_query = Resume::query()
            ->select('resumes.*')
            ->join('applicants', 'resumes.applicant_id', '=', 'applicants.id');
        $params = array_merge(request()->query(), $old_params);

        if (array_key_exists('search', $params))
            $resume_query = $this->search_param_search($resume_query, $params);

        if (array_key_exists('specialization', $params))
            $resume_query = $this->search_param_specialization($resume_query, $params);

        if (array_key_exists('city', $params))
            $resume_query = $this->search_param_city($resume_query, $params);

        if (array_key_exists('salary', $params))
            $resume_query = $this->search_param_salary($resume_query, $params);

        if (array_key_exists('vacancy_experience', $params))
            $resume_query = $this->search_param_vacancy_experience($resume_query, $params);

        return $resume_query;
    }

    private function search_param_search($query, $params)
    {
        $search = $params['search'];
        $query = $query->where('title', 'like', "%$search%");

        return $query;
    }

    private function search_param_specialization($query, $params)
    {
        return $query->where('specialization_id', $params['specialization']);
    }

    private function search_param_city($query, $params)
    {
        return $query->join('cities', 'applicants.city_id', '=', 'cities.id')
                ->where('cities.id', $params['city']);
    }

    private function search_param_salary($query, $params)
    {
        $salary = $this->salaries->where('id', $params['salary'])->first();

        if (!is_null($salary)) return $query->where('salary', '>', $salary->value);

        return $query;
    }

    private function search_param_vacancy_experience($query, $params)
    {
            return $query->where('applicants.vacancy_experience_id', $params['vacancy_experience']);
    }
}
