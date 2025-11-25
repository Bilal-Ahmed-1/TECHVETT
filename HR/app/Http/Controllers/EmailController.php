<?php

namespace App\Http\Controllers;

use App\Mail\welcomeemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function handle(Request $request)
    {
        $request->validate([
            'action' => 'required|in:Accept,Reject,Pending',
            'email' => 'required|email',
            'name' => 'required|string'
        ]);

        $subject = "Techvett Response";
        $data = [
            'action' => $request->action,
            'mailmessage' => '', // fallback message
            'subject' => $subject,
            'name' => $request->name
        ];

        Mail::send('mail.welcome-mail', $data, function ($message) use ($request, $subject) {
            $message->to($request->email)
                    ->subject($subject);
        });

        return response()->json(['message' => 'Email sent successfully.']);
    }
}