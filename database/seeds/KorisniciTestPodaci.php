<?php

use Illuminate\Database\Seeder;
use App\User as Korisnici;

class KorisniciTestPodaci extends Seeder{
    public function run(){
        Korisnici::insert(
            [
                ['ime'=>'Pacijent','prezime'=>'Pacijentović','password'=>bcrypt('pacijent'),'email'=>'pacijent@ddsads.dsas','prava_pristupa_id'=>2,'confirmed'=>1],
                ['ime'=>'Zubar','prezime'=>'Zubarović','password'=>bcrypt('zubar'),'email'=>'zubar@ddsads.dsas','prava_pristupa_id'=>3,'confirmed'=>1],
                ['ime'=>'Admin','prezime'=>'Administratović','password'=>bcrypt('admin'),'email'=>'admin@ddsads.dsas','prava_pristupa_id'=>4,'confirmed'=>1],
            ]);

    }
}
