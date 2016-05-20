<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PravaPristupa extends Model{
    protected $table='prava_pristupa';
    protected $fillable=['naziv'];
    public function korisnik()
    {
        return $this->hasMany('App\User');
    }
}