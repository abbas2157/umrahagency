<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Province;

class LocationController extends Controller
{
    public function index()
    {
        $countries = Country::withCount('provinces')->orderBy('name')->get();
        $provinces = Province::with('country')->withCount('cities')->orderBy('name')->get();
        $cities = City::with('province.country')->withCount('areas')->orderBy('name')->get();
        $areas = Area::with('city.province')->orderBy('name')->get();

        return view('admin.locations.index', compact('countries', 'provinces', 'cities', 'areas'));
    }
}
