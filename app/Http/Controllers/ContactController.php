<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function showForm()
    {
        // Plus de redirection ici !
        return view('contact-form');
    }

    public function sendMail(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé.'], 403);
        }

        $request->validate([
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $user = Auth::user(); // On récupère l'utilisateur connecté

        $details = [
            'title' => 'Mail from Contact Form',
            'name' => $user->name,
            'email' => $user->email,
            'body' => $request->message,
        ];

        try {
            Mail::send('emails.contact', $details, function ($message) use ($details) {
                $message->to('adlenssouci03@gmail.com')
                        ->subject('Contact Form Message');
            });

            return response()->json(['success' => true, 'message' => 'Email envoyé avec succès!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Échec de l\'envoi de l\'email : ' . $e->getMessage()], 500);
        }
    }
}
