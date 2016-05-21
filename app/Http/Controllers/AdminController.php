<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }
    public function getZubar()
    {
        if(!Auth::check()){
            return redirect()->back();
        }
        $usluge=['Lečenje zuba','Vađenje zuba','Poliranje zuba'];
        return view('zubar.index')->with('usluge',$usluge);
        //return view('zubar.index');
    }
    public function getPacijent()
    {
        if(!Auth::check()){
            return redirect()->back();
        }
        return view('pacijent.index');
    }
    public function postLogin(Request $request)
    {
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required'
        ]);
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
            'confirmed' => 1
        ];
        if(!Auth::attempt($credentials,true)){
            return redirect()->back()->with(['fail'=>'Neuspešna prijava!']);
        }
        $user = Auth::user();
        $pravo_pristupa = $user->prava->naziv;

        switch($pravo_pristupa ){
            case 'Administrator':
                return view('admin.index');
                break;
            case 'Zubar':
                return  redirect()->route('zubar.index');
                break;
            case 'Pacijent':
                return redirect()->route('pacijent.index');
                break;
        }





    }
}