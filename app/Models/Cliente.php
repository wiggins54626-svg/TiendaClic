<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $primaryKey = 'usuario_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'usuario_id', 'telefono', 'direccion', 'ciudad',
        'preferencia_notificacion'
    ];
}
