<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('Admin123!'),
        //     'role' => 'admin',
        //     'batch'=>'1'
        // ]);

        // User::create([
        //     'name' => 'haudy',
        //     'email' => 'haudy@gmail.com',
        //     'password' => Hash::make('Admin123!'),
        //     'role' => 'student',
        //     'batch'=>'1'
        // ]);

        User::create([
            'name' => 'Bendahara 1',
            'email' => 'muhamadhaudy25@gmail.com',
            'password' => Hash::make('St76#wW2!'),
            'role' => 'admin',
            'batch'=>'1'
        ]);
    }
}
