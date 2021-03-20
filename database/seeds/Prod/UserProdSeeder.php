<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Léo TIOLLIER',
            'email' => 'ltiollier30@gmail.com',
            'password' => 'password',
        ]);

        User::factory()->create([
            'name' => 'Marine TIOLLIER',
            'email' => 'marine.tiollier@gmail.com',
            'password' => 'password',
        ]);
    }
}
