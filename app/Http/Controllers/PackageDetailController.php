<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PackageDetailController extends Controller
{
    /**
     * Display the specified Umrah package detail page.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // Check if the view exists in the 'umrah' subdirectory
        if (View::exists('umrah.' . $slug)) {
            return view('umrah.' . $slug);
        }

        // Abort if the package/view doesn't exist
        abort(404);
    }

    /**
     * Display the specified Hajj package detail page.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function showHajj($slug)
    {
        if (View::exists('hajj.' . $slug)) {
            return view('hajj.' . $slug);
        }
        abort(404);
    }
}

