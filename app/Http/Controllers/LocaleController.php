<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocaleController extends Controller
{
    /**
     * A logged-in user's choice is saved to their account (it should
     * follow them anywhere they log in); a guest's choice — the login
     * screen is the only unauthenticated page this covers — only lives in
     * the session, since there's no account yet to attach it to.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'locale' => ['required', Rule::in(SetLocale::SUPPORTED)],
        ]);

        if ($request->user()) {
            $request->user()->update(['locale' => $validated['locale']]);
        } else {
            $request->session()->put('locale', $validated['locale']);
        }

        return back();
    }
}
