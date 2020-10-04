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
        $vegetables = [
            'Aubergine',
            'Betterave',
            'Brocoli',
            'Chou-fleur',
            'Courgette',
            'Carotte',
            'Céleri',
            'Pomme de terre',
            'Batavia',
            'Topinambour',
            'Endive',
            'Oignon',
            'Poireau',
            'Epinard',
            'Fenouil'
        ];

        foreach ($vegetables as $vegetable) {
            Vegetable::factory(['name' => $vegetable])->create();
        }
    }
}
