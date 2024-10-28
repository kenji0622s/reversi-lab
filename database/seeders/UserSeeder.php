<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminEmail = config('services.admin.email');
        $adminPassword = config('services.admin.password');
        DB::table('users')->insert([
            [

                'name' => 'Admin',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'is_admin' => true,
            ],
            [
                'name' => 'Test User',
                'email' => 'test@test.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ],
            [
                'name' => 'Test User2',
                'email' => 'test2@test.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ],
        ]);
    }
}
