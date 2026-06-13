<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()
    {
        return view('frontend.pages.about');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
        'first_name' => 'required|string|max:80',
        'last_name'  => 'required|string|max:80',
        'email'      => 'required|email|max:150',
        'phone'      => 'nullable|string|max:30',
        'subject'    => 'nullable|string|max:60',
        'message'    => 'required|string|min:10|max:2000',
        'budget'     => 'nullable|string|max:30',
        'newsletter' => 'nullable|boolean',
    ]);
 
    // Envoi du mail
    Mail::to(config('mail.from.address', 'contact@estatevista.fr'))
        ->send(new ContactMailer($validated));

     return redirect()->route('contact')
        ->with('success', 'Votre message a bien été envoyé. Nous vous répondrons sous 24h ouvrées.');
    }


    public function valuation()
    {
        return view('frontend.pages.valuation');
    }

    public function sendValuation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'property_type' => 'required|string',
            'surface' => 'nullable|numeric',
            'year_built' => 'nullable|integer',
            'message' => 'nullable|string|max:1000',
        ]);

        // Traiter la demande d'estimation
        
        return back()->with('success', 'Demande d\'estimation envoyée ! Un agent vous contactera sous 24h.');
    }

    public function mortgage()
    {
        return view('frontend.pages.mortgage');
    }

    public function privacy()
    {
        return view('frontend.pages.privacy');
    }

    public function terms()
    {
        return view('frontend.pages.terms');
    }

    public function cookies()
    {
        return view('frontend.pages.cookies');
    }

    public function subscribeNewsletter(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        // Sauvegarder dans une table newsletter_subscribers
        // NewsletterSubscriber::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Inscription réussie !'
        ]);
    }
}