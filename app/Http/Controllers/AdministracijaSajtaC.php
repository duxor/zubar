<?php

namespace App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Kontroler administracija sajta
|--------------------------------------------------------------------------
|
| Sadrži sve metode koje se koriste za administriranje pojedinačnih
| sajtova tj. ličnih prezentacija pojedine zubarske ordinacije. Ne
| sadrži metode za prikaz elemenata sajta.
|
*/
use App\Ordinacija;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class AdministracijaSajtaC extends Controller{
    public function getIndex(){
        return view('zubar.index');
    }
    public function postIndexInit(){
        $ordinacija=\App\Ordinacija::first();
        return $ordinacija->radno_vrijeme;
    }
    public function getTermini(){
        return view('zubar.termini');
    }

    public function postRadnoVrijemeSacuvaj(){
        Ordinacija::where('id',1)->update(['radno_vrijeme'=>json_encode(json_decode(Input::get('radno_vrijeme')))]);
        return 1;
    }
}
