<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('123456');
        User::create([
            'username' => 'admin',
            'password' => $password,
            'email' => 'admin@sz.com',
            'email_verified_at' => now(),
            'f_name' => 'admin',
            'country' => 1,
            'city' => 1,
            'user_category_id' => 6
        ]);
    }
}
