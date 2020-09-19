<?php

use App\Models\Cycle;
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
        //before
        Cycle::factory()->count(2)->create([
            'starts_at' => now()->subMonth(),
            'ends_at' => now()->subDay()
        ]);

        //now
        Cycle::factory()->count(20)->create([
            'starts_at' => now()->subMonth(),
            'ends_at' => now()->addMonth()
        ]);

        //futur
        Cycle::factory()->count(10)->create([
            'starts_at' => now()->addDays(4),
            'ends_at' => now()->addMonth()
        ]);
    }
}
