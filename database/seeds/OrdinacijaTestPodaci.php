<?php

use Illuminate\Database\Seeder;
use App\Ordinacija;
use App\UpotrebaTemplejta;

class OrdinacijaTestPodaci extends Seeder{
    public function run(){
        Ordinacija::insert([
            ['naziv'=>'Ordinacija Petrosevic','slug'=>'ordinacija-petrosevic','radno_vrijeme'=>
                json_encode(
                    [
                        ['opseg'=>[0,4],'vrijeme'=>['08:00','17:00']],
                        ['opseg'=>[5],'vrijeme'=>['08:00','13:00']],
                    ]
                ),'email'=>'ordinacija.petrosevic@zubolog.com','telefon'=>'062/333-333','adresa'=>'Radomira Putnika 23','x'=>'43.7234239','y'=>'20.6847863','z'=>'18','grad_id'=>2,
                'neradni_dani'=>json_encode([[21,1],[21,2],[21,3],[21,4],[21,5],])
            ],
        ]);
        UpotrebaTemplejta::insert([
            ['podaci'=>'','templejt_id'=>1,'ordinacija_id'=>1],
            ['podaci'=>'','templejt_id'=>2,'ordinacija_id'=>1],
        ]);
    }
}
