<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact-form');
    }

    // Méthode sendMail pour envoyer l'email
    public function sendMail(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $details = [
            'title' => 'Mail from Contact Form',
            'name' => $request->name,
            'email' => $request->email,
            'body' => $request->message
        ];

        try {
            Mail::send('emails.contact', $details, function ($message) use ($details) {
                $message->to('adlenssouci03@gmail.com')
                    ->subject('Contact Form Message');
            });

            // Retourne une réponse JSON avec success:true
            return response()->json(['success' => true, 'message' => 'Email sent successfully!']);
        } catch (\Exception $e) {
            // En cas d'échec, retourne une réponse JSON avec success:false
            return response()->json(['success' => false, 'message' => 'Email sending failed: ' . $e->getMessage()], 500);
        }
    }
}
