<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Templejt extends Model{
    protected $table='templejt';
    protected $fillable=['naziv','slug'];
}