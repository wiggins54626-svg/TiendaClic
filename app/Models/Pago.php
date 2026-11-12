<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id', 'metodo', 'estado', 'monto', 'referencia_transaccion',
        'comprobante_ruta', 'verificado_por', 'fecha_pago'
    ];
}
