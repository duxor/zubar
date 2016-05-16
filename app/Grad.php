<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grad extends Model{
    protected $table='grad';
    protected $fillable=['naziv','x','y','z'];
}