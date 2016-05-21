<?php

use Illuminate\Database\Seeder;
use App\Ordinacija;
use App\UpotrebaTemplejta;
use App\Usluga;
use App\Rezervacija;

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
        Usluga::insert([
            ['naziv'=>'Lečenje zuba','vreme_realizacije'=>30,'cena'=>1000,'ordinacija_id'=>1],
            ['naziv'=>'Vađenje zuba','vreme_realizacije'=>50,'cena'=>1200,'ordinacija_id'=>1],
            ['naziv'=>'Poliranje zuba','vreme_realizacije'=>15,'cena'=>800,'ordinacija_id'=>1]
        ]);
        for($i=0;$i<51;$i++)
            Rezervacija::insert(
                [
                    'termin'=>'2016-'.str_pad(rand(0,11),2,'0',STR_PAD_LEFT).'-'.str_pad(rand(0,28),2,'0',STR_PAD_LEFT).' '.str_pad(rand(7,15),2,'0',STR_PAD_LEFT).':'.str_pad(rand(0,59),2,'0',STR_PAD_LEFT),
                    'korisnici_id'=>1,
                    'usluga_idevi'=>json_encode([rand(1,3)]),
                    'ordinacija_id'=>1
                ]);
    }
}
