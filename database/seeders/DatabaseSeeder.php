<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Cria um usuário administrador padrão.
     * Altere a senha após o primeiro login!
     */
    public function run(): void
    {
        // Administrador padrão
        User::firstOrCreate(
            ['email' => 'admin@esocial.local'],
            [
                'name'              => 'Administrador',
                'password'          => Hash::make('admin1234'),
                'role'              => 'admin',
                'nr_insc'           => null,
                'email_verified_at' => now(),
            ]
        );

        // Operador de exemplo com empresa vinculada
        User::firstOrCreate(
            ['email' => 'operador@esocial.local'],
            [
                'name'              => 'Operador Exemplo',
                'password'          => Hash::make('operador1234'),
                'role'              => 'operador',
                'nr_insc'           => '12345678',
                'email_verified_at' => now(),
            ]
        );
    }
}
