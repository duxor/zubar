<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usluga extends Model{
    protected $table='usluga';
    protected $fillable=['naziv','opis','vreme_realizacije','cena','ordinacija_id'];
}