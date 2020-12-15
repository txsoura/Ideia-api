<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('local', 'staging')) {
            $this->call([
                TagSeeder::class,
                EventSeeder::class,
                TicketSeeder::class
            ]);
        }
    }
}
