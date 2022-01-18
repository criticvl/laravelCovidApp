<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function list(Request $request){
        return [
            "results" => Countries::select(['id', 'name as text'])->where('name', 'LIKE', '%'.$request->input('q').'%')->take(300)->get()
        ];
    }

    public function searched(Request $request){
        return $request->user()->searchedCountries()->get();
    }

    public function addcountry(Request $request){
        $country = Countries::findOrFail($request->id);
        $request->user()
        ->searchedCountries()
        ->attach($country->id);

        $request->user()->save();
        return ['status' => 'success'];
    }

    public function deletecountry(Request $request){
        $country = Countries::findOrFail($request->id);
        $request->user()
        ->searchedCountries()
        ->detach($country->id);

        $request->user()->save();
        return ['status' => 'success'];
    }

    public function covidWW(Request $request){
    }

}
