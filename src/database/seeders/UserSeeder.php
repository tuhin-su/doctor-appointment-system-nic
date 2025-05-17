<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@email.com',
            'password' => bcrypt('12341234'),
            'role' => 'Patient',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@email.com',
            'password' => bcrypt('12341234'),
            'role' => 'Doctor',
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@email.com',
            'password' => bcrypt('12341234'),
            'role' => 'Admin',
        ]);
    }
}
