<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index(Request $request)
    {
        //
            $departamentos = Departamento::where('estado', 1)->get();
            return response()->json(['departamentos' => $departamentos]);
            //dd($departamentos);
            //return view('clientes.clientes', compact('departamentos'));
        
    }
}
