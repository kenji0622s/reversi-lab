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
        $guestEmail = config('services.guest.email');
        $guestPassword = config('services.guest.password');
        
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'is_admin' => true,
            ],
            [
                'name' => 'Guest',
                'email' => $guestEmail,
                'password' => Hash::make($guestPassword),
                'is_admin' => false,
            ],
        ]);
    }
}
