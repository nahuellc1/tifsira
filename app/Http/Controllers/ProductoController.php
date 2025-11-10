<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\StockMovimiento;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Requests\StockMovimientoRequest;

class ProductoController
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $categoria = $request->input('categoria');

        $productos = Producto::query()
            ->when($q, fn($query) => $query->where(function ($sub) use ($q) {
                $sub->where('nombre', 'like', "%{$q}%")
                    ->orWhere('codigo', 'like', "%{$q}%");
            }))
            ->when($categoria, fn($query) => $query->where('categoria', $categoria))
            ->orderBy('nombre')
            ->paginate(15);

        return view('productos.index', compact('productos'));
    }

    public function create()  { return view('productos.create'); }

    public function store(StoreProductoRequest $request)
    {
        $producto = Producto::create($request->validated());
        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function show(Producto $producto)
    {
        $movimientos = $producto->movimientos()->latest()->take(20)->get();
        return view('productos.show', compact('producto', 'movimientos'));
    }

    public function edit(Producto $producto) { return view('productos.edit', compact('producto')); }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $producto->update($request->validated());
        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function movimiento(StockMovimientoRequest $request, Producto $producto)
    {
        $data = $request->validated();

        if ($data['tipo'] === 'salida' && $producto->stock < $data['cantidad']) {
            return back()->withErrors(['cantidad' => 'No hay suficiente stock para esta salida.']);
        }

        $data['tipo'] === 'entrada'
            ? $producto->increment('stock', $data['cantidad'])
            : $producto->decrement('stock', $data['cantidad']);

        $producto->movimientos()->create([
            'tipo' => $data['tipo'],
            'cantidad' => $data['cantidad'],
            'observacion' => $data['observacion'] ?? null,
        ]);

        return redirect()->route('productos.show', $producto)
                        ->with('success', 'Movimiento registrado correctamente.');
    }
}
