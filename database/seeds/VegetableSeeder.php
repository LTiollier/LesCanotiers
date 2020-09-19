<?php

use App\Models\Vegetable;
use Illuminate\Database\Seeder;

class VegetableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vegetable::factory()->count(10)->create();
    }
}
