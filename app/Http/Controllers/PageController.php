<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EmailContactRequest;
use Mail;

class PageController extends Controller
{
    public function getEmail(){

      return view('email.contact');
    }

    public function postEmail(EmailContactRequest $request){

       $data = [
         'name' => $request->name,
         'email' => $request->email,
         'detail' => $request->detail

       ];

              Mail::send('email.contactBody', $data, function ($m) use ($data) {
                  $m->from('noreply@larablog.com');

                  $m->to('bishanghosal@gmail.com', 'Owner')->subject('Contact');
              });



    }
}
