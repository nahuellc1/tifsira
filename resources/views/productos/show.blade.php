@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Producto: {{ $producto->nombre }}</h1>

    <p><strong>Código:</strong> {{ $producto->codigo }}</p>
    <p><strong>Categoría:</strong> {{ $producto->categoria }}</p>
    <p><strong>Stock:</strong> {{ $producto->stock }}</p>
    <p><strong>Precio:</strong> ${{ number_format($producto->precio,2) }}</p>

    @if(auth()->user()->role === 'admin')
    <hr>
    <h4>Registrar movimiento de stock</h4>
    <form action="{{ route('productos.movimiento', $producto) }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="col">
                <select name="tipo" class="form-control" required>
                    <option value="">Tipo</option>
                    <option value="entrada">Entrada</option>
                    <option value="salida">Salida</option>
                </select>
            </div>
            <div class="col">
                <input type="number" name="cantidad" class="form-control" min="1" placeholder="Cantidad" required>
            </div>
            <div class="col">
                <input type="text" name="observacion" class="form-control" placeholder="Observación (opcional)">
            </div>
            <div class="col">
                <button class="btn btn-success">Registrar</button>
            </div>
        </div>
    </form>
    @endif

    <hr>
    <h4>Movimientos recientes</h4>
    <ul>
        @foreach($movimientos as $m)
            <li>{{ $m->created_at->format('Y-m-d H:i') }} - {{ $m->tipo }} - {{ $m->cantidad }} ({{ $m->observacion }})</li>
        @endforeach
    </ul>

    <a href="{{ route('productos.index') }}" class="btn btn-secondary mt-3">Volver al listado</a>
</div>
@endsection
