<?php

use Illuminate\Database\Seeder;
use App\User as Korisnici;
use App\PravaPristupa;
use App\Grad;

class KonfiguracioniPodaci extends Seeder{
    public function run(){
        PravaPristupa::insert([
            ['naziv'=>'Blokiran'],
            ['naziv'=>'Pacijent'],
            ['naziv'=>'Zubar'],
            ['naziv'=>'Administrator'],
        ]);
        Grad::insert([
            'naziv'=>'Niš',
            'naziv'=>'Beograd',
            'naziv'=>'Leskovac',
        ]);
        Korisnici::insert(
            [
                ['ime'=>'Pacijent','prezime'=>'Pacijentović','username'=>'pacijent','password'=>bcrypt('pacijent'),'prava_pristupa_id'=>'2','email'=>'jovicsasajovic@gmail.com'],
                ['ime'=>'Zubar','prezime'=>'Zubarović','username'=>'zubar','password'=>bcrypt('zubar'),'prava_pristupa_id'=>'3','email'=>'zubar@zubar.zub'],
                ['ime'=>'Admin','prezime'=>'Administratović','username'=>'admin','password'=>bcrypt('admin'),'prava_pristupa_id'=>'4','email'=>'admin@admin.adm'],
            ]);

    }
}
