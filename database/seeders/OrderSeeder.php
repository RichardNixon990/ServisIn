<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Technician;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereHas('role', function ($q) {
            $q->where('nama_role', 'user');
        })->get();

        $technicians = Technician::all();

        if ($users->isEmpty() || $technicians->isEmpty()) {
            dd("Seeder error: User atau Technician belum ada. Jalankan UserSeeder dulu!");
        }

        $statuses = ['pending'];

        foreach ($users as $user) {
            // jumlah pesanan per use
            $orderCount = rand(2, 6);

            for ($i = 0; $i < 10; $i++) {
                Order::create([
                    'user_id' => $user->id,
                    'device_type' => ['laptop', 'hp', 'tablet'][rand(0, 2)],
                    'brand' => ['Asus', 'Lenovo', 'Samsung', 'iPhone', 'Acer'][rand(0, 4)],
                    'issue_description' => Str::random(20),
                    'address' => $user->address,
                    'schedule_date' => now()->addDays(rand(1, 5)),
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }
    }
}
