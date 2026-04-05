<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    public function index(Request $request)
    {
        $municipios = Municipio::where('cod_mh_departamento', $request->departamento_id)->get();

        return response()->json($municipios);
        
    }
}
