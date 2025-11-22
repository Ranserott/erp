<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::latest()->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'rut_cliente' => 'required|string|unique:clientes,rut_cliente',
            'direccion' => 'required|string',
            'contacto_nombre' => 'required|string|max:255',
            'contacto_telefono' => 'required|string|max:255',
            'contacto_email' => 'required|email|max:255',
            'notas' => 'nullable|string'
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load(['cotizaciones', 'ordenesTrabajo', 'facturas']);
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'rut_cliente' => 'required|string|unique:clientes,rut_cliente,' . $cliente->id,
            'direccion' => 'required|string',
            'contacto_nombre' => 'required|string|max:255',
            'contacto_telefono' => 'required|string|max:255',
            'contacto_email' => 'required|email|max:255',
            'notas' => 'nullable|string'
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Cliente $cliente)
    {
        if ($cliente->cotizaciones()->count() > 0 ||
            $cliente->ordenesTrabajo()->count() > 0 ||
            $cliente->facturas()->count() > 0) {

            return redirect()->route('clientes.index')
                ->with('error', 'No se puede eliminar el cliente porque tiene cotizaciones, órdenes de trabajo o facturas asociadas.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
