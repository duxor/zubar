<?php

use Illuminate\Database\Seeder;
use App\User as Korisnici;

class KorisniciTestPodaci extends Seeder{
    public function run(){
        Korisnici::insert(
            [
                ['ime'=>'Pacijent','prezime'=>'Pacijentović','password'=>bcrypt('pacijent'),'email'=>'pacijent@ddsads.dsas'],
                ['ime'=>'Zubar','prezime'=>'Zubarović','password'=>bcrypt('zubar'),'email'=>'zubar@ddsads.dsas'],
                ['ime'=>'Admin','prezime'=>'Administratović','password'=>bcrypt('admin'),'email'=>'admin@ddsads.dsas'],
            ]);

    }
}
