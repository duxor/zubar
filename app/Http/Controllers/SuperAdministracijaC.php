<?php

namespace App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Kontroler super administracija
|--------------------------------------------------------------------------
|
| Sadrži sve metode koje se koriste za administriranje master
| elemenata. Ne sadrži metode za prikaz elemenata sajta.
| Napomena: Razvoj kontrolera nije planiran za MVP, već naknadno.
|
*/
use Illuminate\Http\Request;

use App\Http\Requests;

class SuperAdministracijaC extends Controller{
    public function getIndex(){
        return true;
    }
}
