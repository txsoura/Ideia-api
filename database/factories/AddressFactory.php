<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use App\Models\City;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'street' => $faker->streetName,
        'postcode' => $faker->buildingNumber,
        'number' => $faker->buildingNumber,
        'complement' => $faker->secondaryAddress,
        'district' => $faker->cityPrefix,
        'name' => $faker->citySuffix,
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
        'user_id' =>  function () {
            return factory(User::class)->create()->id;
        },
        'city_id' =>  function () {
            return factory(City::class)->create()->id;
        }
    ];
});
