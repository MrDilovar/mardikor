<?php

namespace App\Http\Controllers\Guest;

use App\City;
use App\Specialization;
use App\Vacancy;
use App\VacancyExperience;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VacancyController extends Controller
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
        $vacancies = $this->get_where_params()->orderBy('id')->paginate(10);

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

        return view('guest.search_vacancy', [
            'specializations'=>$specializations->sortByDesc('vacancies'),
            'selected_specialization'=>$selected_specialization,
            'cities'=>$cities->sortByDesc('vacancies'),
            'selected_city'=>$selected_city,
            'salaries' => $this->salaries,
            'selected_salary'=>$selected_salary,
            'vacancy_experiences'=>$vacancy_experiences,
            'selected_vacancy_experience'=>$selected_vacancy_experience,
            'vacancies'=>$vacancies,
            'PATH_TO_EMPLOYER_PHOTO'=>self::PATH_TO_EMPLOYER_PHOTO,
        ]);
    }

    private function get_where_params($old_params = [])
    {
        $vacancy_query = Vacancy::query();
        $params = array_merge(request()->query(), $old_params);

        if (array_key_exists('search', $params))
            $vacancy_query = $this->search_param_search($vacancy_query, $params);

        if (array_key_exists('specialization', $params))
            $vacancy_query = $this->search_param_specialization($vacancy_query, $params);

        if (array_key_exists('city', $params))
            $vacancy_query = $this->search_param_city($vacancy_query, $params);

        if (array_key_exists('salary', $params))
            $vacancy_query = $this->search_param_salary($vacancy_query, $params);

        if (array_key_exists('vacancy_experience', $params))
            $vacancy_query = $this->search_param_vacancy_experience($vacancy_query, $params);

        return $vacancy_query;
    }

    private function search_param_search($query, $params)
    {
        $search = $params['search'];
        $query = $query::where('name', 'like', "%$search%");

        return $query;
    }

    private function search_param_specialization($query, $params)
    {
        return $query->where('specialization_id', $params['specialization']);
    }

    private function search_param_city($query, $params)
    {
        return $query->where('city_id', $params['city']);
    }

    private function search_param_salary($query, $params)
    {
        $salary = $this->salaries->where('id', $params['salary'])->first();

        if (!is_null($salary)) {
            $query = $query->where(function ($q) use($salary) {
                $q->where('compensation_from_visible', '>=', $salary->value)
                ->orWhere('compensation_to_visible', '>=', $salary->value);
            });
        }

        return $query;
    }

    private function search_param_vacancy_experience($query, $params)
    {
        return $query->where('vacancy_experience_id', $params['vacancy_experience']);
    }
}
