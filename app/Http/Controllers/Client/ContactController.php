<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Contact send mail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contact(Request $request)
    {
        $validatedData = $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required',
            'mailObject' => 'required',
            'mailMessage' => 'required',
        ]);

        $mail = [
            'name' => $request->get('lastname') . ' ' . $request->get('firstname'),
            'email' => $request->get('email'),
            'object' => $request->get('mailObject'),
            'message' => $request->get('mailMessage')
        ];

        Mail::to('luzzi.charly@gmail.com')->send(new ContactMail($mail));

        return response()->json($validatedData);
    }
}
