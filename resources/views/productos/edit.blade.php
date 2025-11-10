@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Producto</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('productos.update' $producto) }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Código</label>
            <input type="text" name="codigo" value="{{ old('codigo') }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Categoría</label>
            <input type="text" name="categoria" value="{{ old('categoria') }}" class="form-control">
        </div>
        <div class="form-group">
            <label>Stock</label>
            <input type="number" name="stock" value="{{ old('stock',0) }}" class="form-control" min="0" required>
        </div>
        <div class="form-group">
            <label>Precio</label>
            <input type="number" step="0.01" name="precio" value="{{ old('precio',0) }}" class="form-control" min="0.01" required>
        </div>
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
