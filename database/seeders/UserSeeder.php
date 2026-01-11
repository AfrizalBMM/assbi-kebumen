<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // pastikan import model User

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@assbi-kebumen.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
