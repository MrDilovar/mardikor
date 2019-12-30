<?php

namespace App\Http\Controllers\Employer;

use App\City;
use App\Employer;
use App\Resume;
use App\Specialization;
use App\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class EmployerController extends Controller
{
    public function home()
    {
        $specializations = Specialization::orderBy('name')->get();

        foreach ($specializations as $specialization) {
            $specialization->resumes = Resume::where('specialization_id', $specialization->id)->count();
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

        return view('employer.page.home', [
            'specializations'=>$specializations,
            'resumes'=>$resumes,
        ]);

    }

    public function index()
    {
        $cities = City::all();

        return view('employer.settings.index',
            [
                'user'=>Auth::user(),
                'PATH_TO_EMPLOYER_PHOTO'=>self::PATH_TO_EMPLOYER_PHOTO,
                'cities'=>$cities
            ]);
    }

    public function employer(Request $request)
    {
        $request->validate([
            'brand'=>'required|max:255',
            'city_id'=>'required|not_in:0',
            'address'=>'max:255',
            'phone'=>'max:255',
            'about_employer'=>'max:1000',
        ]);

        Auth::user()->data->fill($request->all())->save();

        return redirect()->back()->with('success', 'Личные данные были обновлены');
    }

    public function photo(Request $request)
    {
        $request->validate([
            'photo'=>'required|max:10000|mimes:jpeg,png,bmp,gif,svg'
        ]);

        $file = $request->file('photo');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(self::PATH_TO_EMPLOYER_PHOTO, $fileName);

        $employer = Auth::user()->data;

        File::delete(self::PATH_TO_EMPLOYER_PHOTO . $employer->photo);

        $employer->photo = $fileName;
        $employer->save();

        return redirect()->back()->with('success', 'Логотип компании был обновлен');
    }

    public function email(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255'
        ]);

        $user = Auth::user();

        if ($request->email !== $user->email) {
            $request->validate([
                'email' => 'unique:users'
            ]);

            $user->email = $request->email;
            $user->save();
        }

        return redirect()->back()->with('success', 'E-Mail Address был обновлен');
    }

    public function password(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        $valid_password = Auth::validate([
            'email'=>$user->email,
            'password'=>$request->password
        ]);

        if ($valid_password) {
            $user->password = Hash::make($request->new_password);

            $user->save();
        } else {
            return redirect()->back()->with('success', 'Текущий пароль не верен');
        }

        return redirect()->back()->with('success', 'Текущий пароль был обновлен');
    }
}
