<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaisController extends Controller
{
    //
    public function index(Request $request)
    {
        $response = Http::get('https://www.apicountries.com/countries');

        return response()->json($response->json());
        
    }
    
}
