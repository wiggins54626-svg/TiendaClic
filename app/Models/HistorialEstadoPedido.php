<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistorialEstadoPedido extends Model
{
    use HasFactory;

    protected $table = 'historial_estados_pedido';

    const UPDATED_AT = null;

    protected $fillable = [
        'pedido_id', 'estado_anterior', 'estado_nuevo', 'usuario_id'
    ];
}
