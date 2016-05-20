<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpotrebaTemplejta extends Model{
    protected $table='upotreba_templejta';
    protected $fillable=['podaci','templejt_id','ordinacija_id'];
}