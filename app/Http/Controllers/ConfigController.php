<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfigRequest;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index(Config $config) {

        $configs = $config->all();

        $confs = array();

        foreach ($configs as $c) {
            $confs[$c->name] = $c->value;
        }

        return view('config.index', compact('confs'));
    }

    public static function edit_value(string $name, float $value) {

        return view('config.modal.value', compact('name', 'value'));
    }

    public static function create() {
        return view('config.modal.create');
    }

    public static function new_value(string $name) {

        $value = '';

        return view('config.modal.value', compact('name', 'value'));
    }

    public function destroy(string $name) {

        $config = Config::where('name', $name)->first();

        if (!$config) {
            return back();
        }

        $config->value = '0.00';
        $config->save();

        return redirect()->route('config');
    }

    public function update(StoreConfigRequest $request) {
        $data = $request->all();

        foreach ($data as $key => $value) {
            $config = Config::where('name', $key)->first();
            if ($config) {
                $config->value = $value;
                $config->save();
            }
        }

        return redirect()->route('config');
    }

    public function save(Request $request) {
        $data = $request->all();

        foreach ($data['config'] as $d) {
            $config = Config::where('name', $d)->first();
            $config->value = $config->value == '1' ? '0' : '1';
            $config->save();
        }

        return response()->json([200 => 'success']);
    }
}
