<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rezervacija extends Model{
    protected $table='rezervacija';
    protected $fillable=['termin','dijagnoza','ocena','korisnici_id','usluga_idevi','ordinacija_id'];
}