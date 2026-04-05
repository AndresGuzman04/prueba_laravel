<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    public function index(Request $request)
    {


        //
            $documentos = Documento::get();
            return response()->json(['documentos' => $documentos]);

        //dd($documentos);
        
    }
}
