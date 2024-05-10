<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;



if(! function_exists('remember')) {
    function remember($key, $minutes, $data) {
        function getData($d) {
            return $d;
        }

        return Cache::remember($key, $minutes, getData($data));
    }
}

