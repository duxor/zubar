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
use App\Usluga;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class AdministracijaSajtaC extends Controller{
    public function dajPodatak($podatak){
        return \App\Ordinacija::get($podatak)->first();
    }
    public function getIndex(){
        $usluge=Usluga::where('ordinacija_id',1)//['Lečenje zuba','Vađenje zuba','Poliranje zuba'];
            ->lists('naziv','id');
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
    public function postRezervacijeUcitaj(){
        $rezervacije=Rezervacija::join('korisnici as k','k.id','=','rezervacija.korisnici_id')
            ->where('rezervacija.ordinacija_id',1)/////*O_ID***************************************
            ->where(function($query){
                $query->whereNull('ocena')->orWhere('ocena','>',-1);
            })
            ->get(['rezervacija.id','ime','prezime','usluga_idevi as usluga','termin','dijagnoza'])->toArray();
        $usluge=Usluga::where('ordinacija_id',1)/////*O_ID***************************************
                ->lists('naziv','id')->toArray();
        foreach($rezervacije as $i=>$rezervacija){
            $rezervacije[$i]['dijagnoza']=$rezervacije[$i]['dijagnoza']?1:0;
            $rezervacije[$i]['usluga']='';
            foreach(json_decode($rezervacija['usluga']) as $uslugaID)
                $rezervacije[$i]['usluga'].=(strlen($rezervacije[$i]['usluga'])>0?',':'').$usluge[$uslugaID];
        }
        return json_encode($rezervacije);
    }

    /*
     * pacijent:{
     *      id: ?int,
     *      ime: 'string',
     *      prezime: 'string',
     *      email: 'string',
     *      password: 'string',
     *      telefon: 'string'
     * },
     * rezervacija:{
     *      usluga_idevi: array(),
     *      termin: 'string'
     * }
     * 
     */
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
        $rezervacija['usluga_idevi']=json_encode($rezervacija['usluga_idevi']);
        $rezervacija['ordinacija_id']=1;/////*O_ID***************************************
        return Rezervacija::insertGetId($rezervacija);
    }

    /*
     * @ulaz
     * ::id (rezervacije)
     */
    public function postRezervacijaPonisti(){
        Rezervacija::
            where('id',Input::get('id'))
            ->whereNull('dijagnoza')
            ->update(['dijagnoza'=>'Rezervacija je otkazana od strane zubara','ocena'=>-1]);
        return;
    }

    /*
     * @ulaz
     * ::id (rezervacije)
     * ::termin
     */
    public function postRezervacijaPromijeniTermin(){
        Rezervacija::
            where('id',Input::get('id'))
            ->update(['termin'=>Input::get('termin')]);
        return;
    }

    /*
     * @ulaz
     * ::id (rezervacije)
     * ::dijagnoza
     */
    public function postRezervacijaDijagnoza(){
        Rezervacija::
            where('id',Input::get('id'))
            ->update(['dijagnoza'=>Input::get('dijagnoza'),'ocena'=>1]);
        return;
    }

    /*
     * @ulaz
     * ::email
     * ::pin
     */
    public function postRezervacijaPronadjiPacijenta(){
        return json_encode(Korisnici::where('email',Input::get('email'))->where('pin',Input::get('pin'))->get(['id','prezime','ime'])->first());
    }

    public function getGalerija(){
        return view('zubar.galerija');
    }
    public function postGalerijaUcitajFoto(){
        return Ordinacija::find(1,['galerija'])->galerija;
    }
    public function postGalerijaUkloniFoto(){
        $galerija=json_decode(Ordinacija::find(1,['galerija'])->galerija);
        $novaGalerija=[];
        foreach($galerija as $foto){
            $test=true;
            foreach(json_decode(Input::get('fotosi')) as $i=>$f){
                if($f==$foto){
                    $test=false;
                    unlink(substr($foto, 1));
                    break;
                }
            }
            if($test) array_push($novaGalerija,$foto);
        }
        Ordinacija::where('id',1)->update(['galerija'=>json_encode($novaGalerija)]);
        return json_encode($novaGalerija);
    }

    public function postGalerijaDodajFoto(){
        $ordinacijaSlug='slug';
        $imgPath='img/galerija';
        if(!is_dir($imgPath)) mkdir($imgPath);
        $imgPath.='/'.$ordinacijaSlug;
        if(!is_dir($imgPath)) mkdir($imgPath);
        $foto=null;
        if(Input::hasFile('slike'))
            if(Input::file('slike')[0]->isValid()){
                $foto=round(microtime(true)*1000).'_galerijska_'.$ordinacijaSlug.'.'.Input::file('slike')[0]->getClientOriginalExtension();
                Input::file('slike')[0]->move(
                    $imgPath,
                    $foto
                );
                $foto='/'.$imgPath.'/'.$foto;
            }
        if($foto){
            $galerija=Ordinacija::find(1,['galerija'])->galerija;////////ID
            $galerija=json_decode($galerija)!=null?json_decode($galerija):[];
            array_push($galerija, $foto);
            Ordinacija::where('id',1)->update(['galerija'=>json_encode($galerija)]);
        }
        return ['ok'];
    }

    public function getZarada(){

    }
}
