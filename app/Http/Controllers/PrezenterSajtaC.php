<?php

namespace App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Kontroler prezenter sajta
|--------------------------------------------------------------------------
|
| Sadrži sve metode koje se koriste za prikaz pojedinačnih sajtova
| tj. ličnih prezentacija pojedine zubarske ordinacije. Ne sadrži
| metode za izmenu i administriranje istih.
|
*/
use Illuminate\Http\Request;

use App\Http\Requests;

class PrezenterSajtaC extends Controller{
    public function getIndex(){
        return true;
    }
}
