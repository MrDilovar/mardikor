<?php

namespace App\Http\Controllers\Guest;

use App\City;
use App\Mardikor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MardikorController extends Controller
{
    private $paginate_mardikor = 10;

    public function index(Request $request)
    {
        $cities = City::all()->sortBy('name');
        $selected_city = null;

        if (!is_null($request->city))
            $selected_city = $cities->where('id', $request->city)->first();
        else
            foreach ($cities as $city)
                $city->mardikors = Mardikor::where('city_id', $city->id)->count();

        $mardikors = Mardikor::orderByDesc('id');

        if (array_key_exists('city', $request->query()))
            $mardikors = $mardikors->where('city_id', $request->city);

        $mardikors = $mardikors->paginate($this->paginate_mardikor);

        return view('guest.mardikor', [
            'cities'=>$cities,
            'selected_city'=>$selected_city,
            'mardikors'=>$mardikors,
        ]);
    }

    public function create()
    {
        $cities = City::all();
        return view('guest.mardikor_create')->withCities($cities);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employer_name'=>'required|max:50',
            'phone'=>'required|integer|min:9|max:9',
            'city_id'=>'required|not_in:0|int',
            'title'=>'required|max:100',
            'salary'=> !is_null($request->salary) ? 'integer|max:10000' : '',
            'description'=>'max:500',
        ]);

        $mardikor = Mardikor::create($request->all());

        return redirect(route('guest.mardikor.show', $mardikor->id))->with('success', 'Объявление добавлено!');
    }

    public function show($id)
    {
        $mardikor = Mardikor::findOrFail($id);
        return view('guest.mardikor_show')->withMardikor($mardikor);
    }
}
