<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use InvalidConfirmationCodeException;
use App\Http\Requests\RegistrationValidation;
use Mail;
use App\User;
use App\Grad;

class RegistrationController extends Controller
{
    public function getIndex(){
        $grad=Grad::orderBy('naziv','asc')->lists('naziv','id');
        return view('auth.register',compact('grad'));
    }
    public function store(RegistrationValidation $request)
    {


       /*$input = Input::only(
             'username',
             'email',
             'password',
             'password_confirmation'
         );*/


        $confirmation_code = str_random(30);
        try {
            User::insert([
            'ime' => $request->ime,
            'prezime' => $request->prezime,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'prava_pristupa_id'=>$request->zubar_pacijent,
            'grad_id'=>$request->grad,
                'telefon'=>$request->telefon,
            'confirmation_code' =>$confirmation_code
            ]);

            $data['confirmation_code']=$confirmation_code;
            Mail::send('email.verify', $data, function($message) {
                $message->to(Input::get('email'), Input::get('username'))
                    ->subject('Verifikujte Vašu email adresu');
                return Redirect::back()->with('poruka', 'Uspešno ste izvršili registraciju. Proverite vaš email i potvrdite registraciju!');
            });
        } catch ( \Illuminate\Database\QueryException $e) {
            return Redirect::back()->withErrors( 'Greška prilikom upisa korisnik već postoji');
        }
        return Redirect::back();
    }
    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            throw new \InvalidConfirmationCodeException;
        }
        $user = User::whereConfirmationCode($confirmation_code)->first();
        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();
        return Redirect::to('/registracija')->withErrors( 'Uspešno ste se registrovali.Idite na dugme PRIJAVA');
    }
}
