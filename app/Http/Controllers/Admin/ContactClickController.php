<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactClick;
use Illuminate\Http\Request;

class ContactClickController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactClick::query()->latest();

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('value', 'like', "%{$search}%")
                    ->orWhere('page_url', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $clicks = $query->paginate(20)->withQueryString();
        $types = ContactClick::query()->whereNotNull('type')->distinct()->pluck('type');

        return view('admin.contact-clicks.index', compact('clicks', 'types'));
    }

    public function destroy(ContactClick $contactClick)
    {
        $contactClick->delete();

        return redirect()->route('admin.contact-clicks.index')->with('success', 'Record deleted.');
    }
}
