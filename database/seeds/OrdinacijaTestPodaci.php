<?php

use Illuminate\Database\Seeder;
use App\Ordinacija;

class OrdinacijaTestPodaci extends Seeder{
    public function run(){
        Ordinacija::insert([
            ['naziv'=>'Ordinacija Petrosevic','slug'=>'ordinacija-petrosevic','radno_vrijeme'=>
                json_encode(
                    [
                        ['opseg'=>[0,4],'vrijeme'=>['08:00','17:00']],
                        ['opseg'=>[5],'vrijeme'=>['08:00','13:00']],
                    ]
                ),'email'=>'ordinacija.petrosevic@zubolog.com','telefon'=>'062/333-333','adresa'=>'Radomira Putnika 23','x'=>'43.7234239','y'=>'20.6847863','z'=>'18','grad_id'=>2],
        ]);
    }
}
