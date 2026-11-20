<?php
 
namespace Database\Seeders;
 
use App\Models\User;
use Illuminate\Database\Seeder;
 
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@tiendaclic.com')],
            [
                'name' => 'Propietario',
                'password' => env('ADMIN_PASSWORD', 'Cambiar123*'),
                'rol' => 'propietario',
                'activo' => true,
                'acepta_politica_datos' => true,
                'fecha_autorizacion_datos' => now(),
            ]
        );
    }
}