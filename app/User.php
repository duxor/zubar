<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    protected $table='korisnici';
    protected $fillable=['ime','prezime','naziv','username','password','email','pin','bio','telefon','grad_id','prava_pristupa_id','foto','galerija'];
    protected $hidden=['password', 'remember_token'];
}
