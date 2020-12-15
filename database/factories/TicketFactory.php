<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\TicketStatus;
use App\Models\Event;
use App\Models\Ticket;
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

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'status' => new TicketStatus($faker->randomElement(TicketStatus::toArray())),
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 33),
        'event_id' => function () {
            return factory(Event::class)->create()->id;
        },
        'customer_id' => $faker->randomFloat($nbMaxDecimals = 0, $min = 0, $max = 10)
    ];
});
