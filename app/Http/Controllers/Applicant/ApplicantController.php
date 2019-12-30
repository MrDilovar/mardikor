<?php

namespace App\Http\Controllers\Applicant;

use App\Employer;
use App\Specialization;
use App\Vacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use File;
use App\City;
use App\Country;

class ApplicantController extends Controller
{
    public function home()
    {
        $specializations = Specialization::orderBy('name')->get();
        $vacancies = Vacancy::orderBy('id')->get();
        $employers = Employer::orderBy('brand')->get();

        foreach ($specializations as $specialization) {
            $specialization->vacancies = Vacancy::where('specialization_id', $specialization->id)->count();
        }

        foreach ($employers as $employer) {
            $employer->vacancies = Vacancy::where('employer_id', $employer->id)->count();
        }

        return view('applicant.page.home', [
            'specializations'=>$specializations,
            'vacancies'=>$vacancies,
            'employers'=>$employers,
        ]);
    }

    public function applicant_index()
    {
        $cities = City::all();
        $countries = Country::all();

        return view('applicant.settings.applicant', ['applicant'=>Auth::user()->data, 'cities'=>$cities, 'countries'=>$countries]);
    }

    public function applicant_store(Request $request)
    {
        $request->validate([
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:255',
            'gender'=>'in:M,W',
            'birthday'=>'required|date_format:Y-m-d',
            'country_id'=>'required|not_in:0',
            'city_id'=>'required|not_in:0',
            'phone'=>'required|max:255',
            'about_yourself'=>'max:1000',
        ]);

        $applicant = Auth::user()->data;
        $applicant->first_name = $request->first_name;
        $applicant->last_name = $request->last_name;
        $applicant->gender = $request->gender;
        $applicant->birthday = $request->birthday;
        $applicant->country_id = $request->country_id;
        $applicant->city_id = $request->city_id;
        $applicant->phone = $request->phone;
        $applicant->about_yourself = $request->about_yourself;
        $applicant->save();

        return redirect()->back()->with('success', 'Личные данные были обновлены');
    }

    public function photo_index()
    {
        $applicant = Auth::user()->data;
        return view('applicant.settings.photo', [
            'applicant'=>$applicant,
            'PATH_TO_APPLICANT_PHOTO'=>self::PATH_TO_APPLICANT_PHOTO,
        ]);
    }

    public function photo_store(Request $request)
    {
        $request->validate([
            'photo'=>'required|max:10000|mimes:jpeg,png,bmp,gif,svg'
        ]);

        $file = $request->file('photo');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(self::PATH_TO_APPLICANT_PHOTO, $fileName);

        $applicant = Auth::user()->data;

        File::delete(self::PATH_TO_APPLICANT_PHOTO . $applicant->photo);

        $applicant->photo = $fileName;
        $applicant->save();

        return redirect()->back()->with('success', 'Изображения был обновлен');
    }

    public function login_index()
    {
        return view('applicant.settings.login', ['user'=>Auth::user()]);
    }
}
