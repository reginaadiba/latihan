<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        User::factory()
            ->count(5)
            ->create();

        // DB::table('users')->insert([
        //     'name' => 'admin',
        //     'email' => 'admin@mail.com',
        //     'password' => Hash::make('123456')
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'admin2',
        //     'email' => 'admin2@mail.com',
        //     'password' => Hash::make('123456')
        // ]);
    }
}
