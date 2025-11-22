<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@erp.local'],
            [
                'name' => 'Administrador ERP',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'usuario@erp.local'],
            [
                'name' => 'Usuario Demo',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
            ]
        );
    }
}