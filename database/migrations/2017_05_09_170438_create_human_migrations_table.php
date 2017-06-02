<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHumanMigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('human_migrations', function (Blueprint $table) {

            $table->increments('id');

            $table->string('departure_country');
            $table->string('departure_city');

            $table->string('arrival_country');
            $table->string('arrival_city');

            $table->integer('departure_latitude');
            $table->integer('departure_longitude');

            $table->integer('arrival_latitude');
            $table->integer('arrival_longitude');

            $table->integer('adults')->default(0);
            $table->integer('children')->default(0);

            $table->longText('reason');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('human_migrations');
    }
}
