<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarritoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrito_id', 'producto_id', 'cantidad'
    ];
}
