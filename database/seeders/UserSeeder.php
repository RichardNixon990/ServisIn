<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Technician;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ================================
        // 1. Buat Role Jika Belum Ada
        // ================================
        $adminRole = Role::firstOrCreate(['nama_role' => 'admin']);
        $technicianRole = Role::firstOrCreate(['nama_role' => 'technician']);
        $userRole = Role::firstOrCreate(['nama_role' => 'user']);

        // ================================
        // 2. Create Admin
        // ================================
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'phone' => '081234567890',
                'address' => 'Admin Address',
                'role_id' => $adminRole->id
            ]
        );

        // ================================
        // 3. Generate Banyak Teknisi
        // ================================
        // for ($i = 1; $i <= 5; $i++) {  // === jumlah teknisi disini ubah sesukamu ===

        //     $techUser = User::firstOrCreate(
        //         ['email' => "technician$i@example.com"],
        //         [
        //             'name' => "Technician $i",
        //             'password' => Hash::make('password123'),
        //             'phone' => "08234567890$i",
        //             'address' => "Technician $i Address",
        //             'role_id' => $technicianRole->id
        //         ]
        //     );

        //     Technician::firstOrCreate(
        //         ['user_id' => $techUser->id],
        //         [
        //             'specialization' => Arr::random(['Laptop', 'HP', 'Elektronik', 'Komputer']),
        //             'experience_years' => rand(1, 12),
        //             'status' => Arr::random(['online', 'offline'])
        //         ]
        //     );
        // }

        // ================================
        // 4. Create User Biasa
        // ================================
        // User::firstOrCreate(
        //     ['email' => 'user@example.com'],
        //     [
        //         'name' => 'User Biasa',
        //         'password' => Hash::make('password123'),
        //         'phone' => '083456789012',
        //         'address' => 'User Address',
        //         'role_id' => $userRole->id
        //     ]
        // );
    }
}
