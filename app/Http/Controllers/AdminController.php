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
        return view('zubar.index');
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
            'username'=>'required',
            'password'=>'required'
        ]);
        $credentials = [
            'username' => $request['username'],
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