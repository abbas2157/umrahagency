<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function aboutUs()
    {
        return view('about-us');
    }

    public function contactUs()
    {
        return view('contact-us');
    }

    public function reviews()
    {
        return view('reviews');
    }

    public function termsConditions()
    {
        return view('terms-and-conditions');
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function paymentSecurity()
    {
        return view('payment-security');
    }

    public function cookiesPolicy()
    {
        return view('cookie-policy');
    }

    public function hajj()
    {
        return view('hajj');
    }

    public function umrahVisa()
    {
        return view('umrah-visa');
    }

    public function umrahPackages()
    {
        return view('umrah-packages');
    }

    public function umrahPackages2026()
    {
        return view('umrah-packages-2026');
    }

    public function decemberUmrahPackages()
    {
        return view('december-umrah-packages');
    }

    public function ramadanUmrah()
    {
        return view('ramzan-umrah-packages');
    }

    public function easterUmrahPackages()
    {
        return view('easter-umrah-packages');
    }

    public function lahoreUmrah()
    {
        return view('lahore-umrah-packages');
    }

    public function sendInquiry(Request $request)
    {
        $request->validate([
            'n.email' => 'required|email',
            'n.name' => 'required',
            'n.Phone Number' => 'nullable',
            'n.Departure Date' => 'nullable',
            'n.Departure Airport' => 'nullable',
            'InquiryAnswer' => 'required',
        ]);
        $formId = $request->input('form_id');
        $expected = $formId ? session('captcha_answer_' . $formId) : session('captcha_answer');
        if ($request->input('InquiryAnswer') != $expected) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Incorrect CAPTCHA answer. Please try again.']);
            }
            return back()->with('error', 'Incorrect CAPTCHA answer. Please try again.')->withInput();
        }
        $data = $request->input('n');
        try {
            \App\Models\Inquiry::create([
                'departure_airport' => $data['Departure Airport'] ?? null,
                'departure_date'    => $data['Departure Date'] ?? null,
                'hotel_category'    => $data['Hotel Category'] ?? null,
                'duration'          => $data['Duration'] ?? null,
                'travelers'         => $data['No. of Travelers'] ?? null,
                'name'              => $data['name'] ?? null,
                'phone'             => $data['Phone Number'] ?? null,
                'email'              => $data['email'] ?? null,
                'message'           => trim(($data['subject'] ?? '') . "\n\n" . ($request->input('message') ?? '')),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Inquiry database save failed: ' . $e->getMessage());
        }
        
        try {
            \u001cIlluminate\Support\Facades\Mail::send('emails.inquiry', ['data' => $data], function($message) use ($data) {
                $message->to('info@umrahagency.pk');
                $message->replyTo($data['email']);
                $message->subject('New Package Inquiry - ' . ($data['name'] ?? 'Umrah Agency Pakistan'));
            });
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Thank you! Your inquiry has been sent successfully.']);
            }
            return back()->with('success', 'Thank you! Your inquiry has been sent successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail sending failed: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Thank you! Your inquiry has been received and we will get back to you soon.']);
            }
            return back()->with('success', 'Thank you! Your inquiry has been received and we will get back to you soon.');
        }
    }

    public function getCaptcha(Request $request)
    {
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $answer = $num1 + $num2;
        $formId = $request->query('form_id');
        
        if ($formId) {
            session(['captcha_answer_' . $formId => $answer]);
        } else {
            session(['captcha_answer' => $answer]);
        }
        return response($num1 . ' + ' . $num2 . ' = ?');
    }

    public function logContactClick(Request $request)
    {
        try {
            \App\Models\ContactClick::create([
                'type' => $request->input('type'),
                'value' => $request->input('value'),
                'page_url' => $request->input('page_url'),
                'ip_address' => $request->ip(),
                'country' => 'UK',
            ]);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Contact click logging failed: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}

