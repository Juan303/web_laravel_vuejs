<?php
/**
 * Created by PhpStorm.
 * User: Bob
 * Date: 21/10/2018
 * Time: 20:37
 */

namespace App\Helpers;


class Helper
{
    public static function uploadFile($key, $path){
        request()->file($key)->store($path);
        return request()->file($key)->hashName();
    }
}