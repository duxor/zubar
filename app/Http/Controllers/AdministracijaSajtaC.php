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
use App\User as Korisnici;
use App\Rezervacija;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class AdministracijaSajtaC extends Controller{
    public function dajPodatak($podatak){
        return \App\Ordinacija::get($podatak)->first();
    }
    public function getIndex(){
        $usluge=['Lečenje zuba','Vađenje zuba','Poliranje zuba'];
        return view('zubar.index')->with('usluge',$usluge);
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

    public function postRezervacija(){
        $id=Input::get('idPacijenta');
        if(!$id){
            $pacijent=Input::get('pacijent');
            $pacijent['password']=bcrypt($pacijent['password']);
            $pacijent['prava_pristupa_id']=2;
            $id=Korisnici::insertGetId($pacijent);
        }
        $rezervacija=Input::get('rezervacija');
        $rezervacija['korisnici_id']=$id;
        $rezervacija['ordinacija_id']=1;/////****************************************
        Rezervacija::insert($rezervacija);
        return;
    }
}
