<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\UserSex;
use App\Models\Profile;
use App\Models\Address;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'name' =>  $faker->name,
        'cpf_cnpj' => $faker->randomDigitNotNull,
        'birthdate' =>   now(),
        'cellphone' => $faker->e164PhoneNumber,
        'sex' => new UserSex($faker->randomElement(UserSex::toArray())),
        'img' => $faker->imageUrl($width = 640, $height = 480),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'address_id' => function () {
            return factory(Address::class)->create()->id;
        }
    ];
});
