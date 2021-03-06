<?php

use Illuminate\Database\Seeder;

class CycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vegetables = \App\Models\Vegetable::all();
        $parcels = \App\Models\Parcel::all();

        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Cycle::factory([
                'starts_at' => now()->subMonth(),
                'ends_at' => now()->addMonth(),
                'vegetable_id' => $vegetables->random()->getKey(),
                'parcel_id' => $parcels->random()->getKey(),
            ])->create();
        }
    }
}
