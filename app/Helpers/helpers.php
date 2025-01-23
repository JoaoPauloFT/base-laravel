<?php

if (!function_exists('get_settings')) {
    function get_settings($param) {
        return \App\Models\Config::where('name', $param)->first()->value ?? '';
    }
}
