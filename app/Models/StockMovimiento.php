<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'tipo',
        'cantidad',
        'observacion',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
