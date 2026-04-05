<?php

namespace App\Http\Controllers;

use App\Models\Giro;
use Illuminate\Http\Request;

class GiroController extends Controller
{
    public function index(Request $request)
    {
        //
            $giros = Giro::get();
            return response()->json(['giros' => $giros]);
            //dd($giros);
            //return view('clientes.clientes', compact('giros'));
        
    }
}
