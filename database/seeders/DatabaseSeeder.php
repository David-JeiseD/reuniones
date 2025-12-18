<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ugel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Llamamos a tu RoleSeeder existente
        $this->call([
            RoleSeeder::class, 
            // Aquí puedes añadir más seeders si creas otros en el futuro
        ]);

        // 2. Crear una UGEL base (si no existe)
        // Esto es necesario para que el admin tenga una UGEL asignada al nacer
        $ugelBase = Ugel::firstOrCreate(['nombre' => 'SEDE CENTRAL']);

        // 3. Crear el Súper Admin
        // Usamos firstOrCreate para que no dé error si vuelves a correr el comando
        $admin = User::firstOrCreate(
            ['email' => 'admin@sistema.com'], // Buscamos por email
            [
                'name' => 'Administrador General',
                'dni' => '00000000',
                'password' => Hash::make('admin123'), // Contraseña por defecto
                'cargo' => 'Administrador',
                'ugel_id' => $ugelBase->id,
                'perfil_completo' => true, 
            ]
        );

        // 4. Asignar el rol de admin al usuario creado
        // El rol ya existe porque llamamos al RoleSeeder en el paso 1
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $this->command->info('Sistema inicializado: Roles creados y Admin registrado (admin@sistema.com / admin123)');
    }
}
