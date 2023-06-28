<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('site_settings')->count();
        if ($count == 0) {
            DB::table('site_settings')->insert(
                [
                    [
                        'title' => 'Nogor Solutions',
                        'short_title' => 'nsl',
                        'contact_email' => 'nsl@gmail.com',
                        'feedback_email' => 'nsl@gmail.com',
                        'mobile1' => '01700000000',
                        'mobile2' => '01700000000',
                        'address' => 'Dhaka',
                        'web' => 'https://nogorsolutions.com/',
                        'developed_by' => 'Nogor Solutions',
                        'developed_by_url' => 'https://nogorsolutions.com/',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]
            );
        }
    }
}
