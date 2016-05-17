<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->call(KonfiguracioniPodaci::class);
        $this->call(KorisniciTestPodaci::class);
        $this->call(OrdinacijaTestPodaci::class);
    }
}
