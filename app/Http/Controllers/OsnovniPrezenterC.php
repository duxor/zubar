<?php

namespace App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Osnovni prezenter
|--------------------------------------------------------------------------
|
| Sadrži sve metode koje se koriste za prikaz master sajta koji
| objedinjuje sve pojedinačne zubarske ordinacije i njihove
| sajtove. Ne sadrži metode za administriranje.
|
*/
use Illuminate\Http\Request;

use App\Http\Requests;

class OsnovniPrezenterC extends Controller{
    public function getIndex(){
        return true;
    }
}
