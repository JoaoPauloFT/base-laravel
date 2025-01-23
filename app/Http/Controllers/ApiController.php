<?php

namespace App\Http\Controllers;


use App\Models\Config;

class ApiController extends Controller
{
    public function getAllConfigs()
    {
        try {
            $configs = Config::all();

            return response()->json($configs);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e], 400);
        }
    }
}
