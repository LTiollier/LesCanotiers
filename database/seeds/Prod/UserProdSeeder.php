<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Léo TIOLLIER',
                'email' => 'ltiollier30@gmail.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Marine TIOLLIER',
                'email' => 'marine.tiollier@gmail.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        ]);
    }
}
