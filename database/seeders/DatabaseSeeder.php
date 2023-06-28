<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $arr = [
            MenuSeeder::class,
            AdminSeeder::class,
            RoleSeeder::class,
            SiteSettingsSeeder::class,
            SliderDetailsSeeder::class,
        ];
        $this->call($arr);
    }
}
