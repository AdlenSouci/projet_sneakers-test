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
        ]);

        $details = [
            'title' => 'Mail from Contact Form',
            'name' => $request->name,
            'email' => $request->email,
            'body' => $request->message
        ];

        Mail::send('emails.contact', $details, function ($message) use ($details) {
            $message->to('adlenssouci03@gmail')  // Remplacez par l'adresse email où vous souhaitez recevoir les messages
                ->subject('Contact Form Message');
        });

        return response()->json(['message' => 'Email sent successfully!']);
    }
}
