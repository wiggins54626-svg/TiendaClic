<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_orden', 'usuario_id', 'estado', 'total', 'metodo_pago',
        'nombre_destinatario', 'direccion_envio', 'ciudad_envio',
        'telefono_contacto', 'motivo_cancelacion'
    ];
}
