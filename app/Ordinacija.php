<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ordinacija extends Model{
    protected $table='ordinacija';
    protected $fillable=['naziv','slug','radno_vreme','neradni_dani','email','telefon','adresa','x','y','z','templejt_id','grad_id'];
}