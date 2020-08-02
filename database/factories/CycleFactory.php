<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cycle;
use App\Models\Parcel;
use App\Models\Vegetable;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Cycle::class, function (Faker $faker) {
    return [
        'starts_at' => $faker->date(),
        'ends_at' => $faker->date(),
        'vegetable_id' => function () {
            return factory(Vegetable::class)->create()->getKey();
        },
        'parcel_id' => function () {
            return factory(Parcel::class)->create()->getKey();
        },
    ];
});
