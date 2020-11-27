<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'balance' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        }

    ];
});
