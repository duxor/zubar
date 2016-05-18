<?php

use Illuminate\Database\Seeder;
use App\PravaPristupa;
use App\Grad;
use App\Templejt;

class KonfiguracioniPodaci extends Seeder{
    public function run(){
        PravaPristupa::insert([
            ['naziv'=>'Blokiran'],
            ['naziv'=>'Pacijent'],
            ['naziv'=>'Zubar'],
            ['naziv'=>'Administrator'],
        ]);
        Grad::insert([
            ['naziv'=>'Nedefinisan'],
            ['naziv'=>'Kraljevo'],
            ['naziv'=>'Beograd'],
            ['naziv'=>'Vranje'],
        ]);
        Templejt::insert([
            ['naziv'=>'Tema 1','slug'=>'tema-1'],
            ['naziv'=>'Tema 2','slug'=>'tema-2'],
        ]);
    }
}
