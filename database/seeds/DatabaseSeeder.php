<?php

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
        $this->call(UserSeeder::class);
        $this->call(VegetableSeeder::class);
        $this->call(ParcelSeeder::class);
        $this->call(CycleSeeder::class);
        $this->call(ActivitySeeder::class);
    }
}
