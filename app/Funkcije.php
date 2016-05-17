<?php
/**
 * Created by PhpStorm.
 * User: Dušan
 * Date: 5/17/2016
 * Time: 20:27
 */

namespace App;


class Funkcije{
    public static function kreirajSlug($text,$objekat){
        $slug = null;
        $tmp=strtr($text,['Š'=>'s','š'=>'s','Đ'=>'d','đ'=>'d','Č'=>'c','č'=>'c','Ć'=>'c','ć'=>'c','Ž'=>'z','ž'=>'z']);
        $tmp = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $tmp));
        if ($tmp[strlen($tmp) - 1] == '-') $tmp = substr($tmp, 0, strlen($tmp) - 1);
        $i = 0;
        while (!$slug){
            if (!$objekat->where('slug', $tmp . ($i == 0 ? '' : '-' . $i))->exists()) $slug = $tmp . ($i == 0 ? '' : '-' . $i);
            $i++;
        }
        return $slug;
    }
}