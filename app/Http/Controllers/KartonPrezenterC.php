<?php

namespace App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Kontroler profilni prezenter
|--------------------------------------------------------------------------
|
| Sadrži sve metode koje se koriste za prikaz i
| administriranje zubarskog kartona pacijenta
|
*/
use App\Grad;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User as Pacijent;
use App\Rezervacija as Intervencije;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class KartonPrezenterC extends Controller{
    public function getIndex($slug=null){
        $pacijent=Pacijent::join('grad as g','g.id','=','grad_id')
            ->where('prava_pristupa_id',2)
            ->get(['korisnici.id','ime','prezime','email','pin','bio','telefon','g.naziv as grad','foto'])
            ->first();
        $intervencije=Intervencije::join('ordinacija as o','o.id','=','ordinacija_id')
            ->where('korisnici_id',$pacijent->id)
            ->whereNotNull('dijagnoza')
            ->get(['dijagnoza','o.naziv as ordinacija','ocena']);
        if($slug=='izmeni'){
            $gradovi=Grad::lists('naziv','id');
            foreach($gradovi as $i=>$grad)
                if($grad==$pacijent->grad) $pacijent->grad=$i;
            return view('pacijent.izmeni')->with(compact('pacijent','gradovi'));
        }
        return view('pacijent.index')->with(compact('pacijent','intervencije'));
    }
    public function postIndex(){
        $userID=1;////Auth::user()->id
        $podaci=Input::all();
        unset($podaci['_token']);
        if(!is_dir('img/korisnici')) mkdir('img/korisnici');
        if(isset($podaci['foto']))
            if($podaci['foto']->isValid()){
                $foto='profilna_'.$userID.'.'.$podaci['foto']->getClientOriginalExtension();
                $podaci['foto']->move(
                    'img/korisnici',
                    $foto
                );
                $podaci['foto']='/img/korisnici/'.$foto;
            }
        Pacijent::where('id',$userID)->update($podaci);
        return Redirect::back();
    }
}
