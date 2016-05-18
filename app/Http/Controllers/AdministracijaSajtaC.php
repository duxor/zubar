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
    public function dajPodatak($podatak){
        return \App\Ordinacija::get($podatak)->first();
    }
    public function getIndex(){
        return view('zubar.index');
    }
    public function postIndexInit(){
        return $this->dajPodatak(['radno_vrijeme'])->radno_vrijeme;
    }
    public function getNeradniDani(){
        return view('zubar.neradni-dani')->with('neradni_dani',$this->dajPodatak(['neradni_dani'])->neradni_dani);
    }
    public function postNeradniDaniSacuvaj(){
        Ordinacija::where('id',1)->update(['neradni_dani'=>Input::get('neradni_dani')]);
        return 1;
    }

    public function postRadnoVrijemeSacuvaj(){
        Ordinacija::where('id',1)->update(['radno_vrijeme'=>Input::get('radno_vrijeme')]);
        return 1;
    }
}
