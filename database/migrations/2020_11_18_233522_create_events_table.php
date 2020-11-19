<?php

use App\Enums\EventAccess;
use App\Enums\EventRestriction;
use App\Enums\EventStatus;
use App\Enums\EventType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('tags')->nullable();
            $table->dateTime('start');
            $table->enum('access', EventAccess::toArray())->default(EventAccess::FREE);
            $table->decimal('price',10,2)->default(0.00);
            $table->enum('type', EventType::toArray())->default(EventType::PUBLIC);
            $table->enum('restriction', EventRestriction::toArray())->default(EventRestriction::NONE);
            $table->dateTime('available')->default(now());
            $table->integer('ticket')->default(0);
            $table->enum('status', EventStatus::toArray())->default( EventStatus::PENDENT);
            $table->foreignId('owner_id')->references('id')->on('users');
            $table->foreignId('address_id')->references('id')->on('addresses')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
