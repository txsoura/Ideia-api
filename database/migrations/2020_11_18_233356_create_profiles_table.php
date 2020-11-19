<?php

use App\Enums\UserSex;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->bigInteger('cpf_cnpj')->nullable();
            $table->string('img')->nullable();
            $table->date('birthdate')->nullable();
            $table->bigInteger('cellphone')->nullable();
            $table->enum('sex', UserSex::toArray())->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('profiles');
    }
}
