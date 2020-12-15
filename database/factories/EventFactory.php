<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\EventAccess;
use App\Enums\EventRestriction;
use App\Enums\EventStatus;
use App\Enums\EventType;
use App\Models\Event;
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

$factory->define(Event::class, function (Faker $faker) {
    $tags = array();
    for ($i = 0; $i < 3; $i++) {
        $tags[] = $faker->unique()->randomDigit;
    }

    $imgs = array();
    for ($i = 0; $i < 3; $i++) {
        $imgs[] = $faker->unique()->imageUrl($width = 640, $height = 480); // 'http://lorempixel.com/640/480/';
    }

    return [
        'name' => $faker->name,
        'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'tags' => $tags,
        'start' => $faker->dateTime($max = 'now', $timezone = null), // DateTime('2008-04-25 08:37:17', 'UTC'),
        'access' => new EventAccess($faker->randomElement(EventAccess::toArray())),
        'price' => $faker->randomFloat($nbMaxDecimals = 0, $min = 0, $max = 33),
        'type' => new EventType($faker->randomElement(EventType::toArray())),
        'restriction' => new EventRestriction($faker->randomElement(EventRestriction::toArray())),
        'available' => $faker->dateTime($max = 'now', $timezone = null), // DateTime('2008-04-25 08:37:17', 'UTC'),
        'status' => new EventStatus($faker->randomElement(EventStatus::toArray())),
        'ticket' => $faker->randomDigit,
        'producer_id' => $faker->randomFloat($nbMaxDecimals = 0, $min = 0, $max = 10),
        'address_id' => $faker->randomFloat($nbMaxDecimals = 0, $min = 0, $max = 10),
        'img' => $imgs
    ];
});
