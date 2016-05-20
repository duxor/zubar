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
        Grad::insert(['naziv'=>'Nedefinisan']);

        Korisnici::insert(
            [
                ['ime'=>'Pacijent','prezime'=>'Pacijentović','username'=>'pacijent','password'=>bcrypt('pacijent'),'prava_pristupa_id'=>'2','email'=>'jovicsasajovic@gmail.com'],
                ['ime'=>'Zubar','prezime'=>'Zubarović','username'=>'zubar','password'=>bcrypt('zubar'),'prava_pristupa_id'=>'3','email'=>'zubar@zubar.zub'],
                ['ime'=>'Admin','prezime'=>'Administratović','username'=>'admin','password'=>bcrypt('admin'),'prava_pristupa_id'=>'4','email'=>'admin@admin.adm'],
            ]);

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
