<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('admins')->count();
        if ($count == 0) {
            DB::table('admins')->insert(
                [
                    [
                        'role_id' => 1,
                        'name' => 'Nogor Solutions',
                        'username' => 'nsl',
                        'mobile' => '01700000000',
                        'email' => 'nsl@gmail.com',
                        'password' => Hash::make('nsl@123'),
                        'status' => 'active',
                        'remember_token' => Str::random(10),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'role_id' => 2,
                        'name' => 'Nogor',
                        'username' => 'nogor',
                        'mobile' => '01700000001',
                        'email' => 'nogor@gmail.com',
                        'password' => Hash::make('nogor@123'),
                        'status' => 'active',
                        'remember_token' => Str::random(10),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]
            );
        }
    }
}
