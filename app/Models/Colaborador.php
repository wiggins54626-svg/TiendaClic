<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Colaborador extends Model
{
    use HasFactory;

    protected $table = 'colaboradores';
    protected $primaryKey = 'usuario_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'usuario_id', 'cargo'
    ];
}
