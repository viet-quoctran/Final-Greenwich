<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Quốc Việt',
            'email' => 'vietquoctran2502@gmail.com',
            'password' => bcrypt('quocviet2502'),
            'is_admin' => true // Đảm bảo rằng bạn có trường 'is_admin' trong bảng users của bạn
        ]);
    }
}
