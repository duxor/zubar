<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ordinacija extends Model{
    protected $table='ordinacija';
    protected $fillable=['naziv','slug','radno_vreme','email','telefon','adresa','x','y','z','grad_id'];
}