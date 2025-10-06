<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::Create(
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'is_admin' => 1,
            ]
        );
    }
}
