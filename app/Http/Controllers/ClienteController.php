<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{   

    public function index(Request $request)
    {

        //$clientes = Cliente::latest()->get();
        //dd($clientes);

        //
        if ($request->ajax()) {
            $clientes = Cliente::latest()->get();
            return response()->json(['clientes' => $clientes]);
        }
        return view('clientes.clientes');

        
    }
}
