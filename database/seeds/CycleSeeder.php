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
        factory(Cycle::class, 10)->create([
            'starts_at' => now()->subMonth(),
            'ends_at' => now()->subDay()
        ]);

        //now
        factory(Cycle::class, 10)->create([
            'starts_at' => now()->subMonth(),
            'ends_at' => now()->addMonth()
        ]);

        //futur
        factory(Cycle::class, 10)->create([
            'starts_at' => now()->addDays(4),
            'ends_at' => now()->addMonth()
        ]);
    }
}
