<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{   
    // View clientes
    public function view ()
    {
        return view('clientes.clientes');
    }

    // Get all clientes
    public function index()
    {
        //$clientes = Cliente::latest()->get();
        //dd($clientes);
        $clientes = Cliente::orderBy('id_catalogo_cliente', 'desc')->get();
        return response()->json(['clientes' => $clientes]);
      
    }

    // Get cliente by id
    public function show(string $id)
    {
        //
        $cliente = Cliente::find($id);
        return response()->json(['cliente' => $cliente]);
    }

    // Create cliente
    public function store(StoreClienteRequest $request)
    {
        $clientes = Cliente::create($request->validated());
        return response()->json(['success' => $clientes]);
    }

    // Update cliente
    public function update(UpdateClienteRequest $request, string $id)
    {
        //
        $clientes = Cliente::find($id);
        $clientes->update($request->validated());
        return response()->json(['success' => $clientes]);
    }

    // Delete cliente
    public function destroy(string $id)
    {
        //
        $cliente = Cliente::find($id);
        $cliente->delete();
        return response()->json(['success' => 1]);
    }
}
