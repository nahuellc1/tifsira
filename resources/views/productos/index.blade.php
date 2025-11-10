@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Productos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <form method="GET" class="form-inline">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por nombre o código" class="form-control mr-2">
            <input type="text" name="categoria" value="{{ request('categoria') }}" placeholder="Categoría" class="form-control mr-2">
            <button class="btn btn-primary">Buscar</button>
            @can('admin-only')
                <a href="{{ route('productos.create') }}" class="btn btn-success ml-2">Nuevo Producto</a>
            @endcan
        </form>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $p)
            <tr>
                <td>{{ $p->codigo }}</td>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->categoria }}</td>
                <td>{{ $p->stock }}</td>
                <td>${{ number_format($p->precio,2) }}</td>
                <td>
                    <a href="{{ route('productos.show', $p) }}" class="btn btn-sm btn-info">Ver</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('productos.edit', $p) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('productos.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar producto?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $productos->links() }}
</div>
@endsection
