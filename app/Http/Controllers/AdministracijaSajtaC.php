<?php

namespace App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Kontroler administracija sajta
|--------------------------------------------------------------------------
|
| Sadrži sve metode koje se koriste za administriranje pojedinačnih
| sajtova tj. ličnih prezentacija pojedine zubarske ordinacije. Ne
| sadrži metode za prikaz elemenata sajta.
|
*/
use Illuminate\Http\Request;

use App\Http\Requests;

class AdministracijaSajtaC extends Controller{
    public function getIndex(){
        return true;
    }
}
