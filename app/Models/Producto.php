<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id', 'nombre', 'descripcion', 'precio',
        'stock', 'stock_minimo', 'imagen', 'activo'
    ];
}
