<?php

namespace App\Http\Controllers;

use App\Models\TipoContribuyente;
use Illuminate\Http\Request;

class TipoContribuyenteController extends Controller
{
    public function index(Request $request)
    {


        //
            $tipo_contribuyentes = TipoContribuyente::get();
            return response()->json(['tipo_contribuyentes' => $tipo_contribuyentes]);
            //dd($tipo_contribuyentes);

        //dd($tipo_contribuyentes);
        
    }
}
