<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Client::create([
            'first_name' => 'Javier',
            'last_name' => 'Arroyo',
            'email' => 'javier@test.com',
            'phone_number' => '123456789'
        ]);

        \App\Models\Client::create([
            'first_name' => 'Luis',
            'last_name' => 'Hernandez',
            'email' => 'luis@test.com'
        ]);

        \App\Models\Client::create([
            'first_name' => 'Tomas',
            'last_name' => 'Lopez',
            'email' => 'tomas@test.com'
        ]);
    }
}
