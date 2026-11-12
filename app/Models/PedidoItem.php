<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PedidoItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'pedido_id', 'producto_id', 'nombre_producto',
        'precio_unitario', 'cantidad', 'subtotal'
    ];
}
