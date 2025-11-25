<?php

namespace App\Http\Controllers;

use App\Mail\welcomeemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(){
        $toEmail = "bilalahmed082000@gmail.com";
        $message = "Hello, Welcome to cms poratl";
        $subject = "TECHVETT@HR";

    $emails = [
        'bilalahmed082000@gmail.com',
        'aaimasohail2710@gmail.com',
        'dawoodm.shoaib@gmail.com',
        'msaifkhan587@gmail.com',
    ]; 
    
    foreach ($emails as $recipient)
    {
        Mail::to($recipient)->send(new welcomeemail($message,$subject));

    }
        //$request = Mail::to($toEmail)->send(new welcomeemail($message,$subject));

        //dd($request);
    }
}