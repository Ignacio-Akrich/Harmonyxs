<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_medias', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('pagweb')->nullable();

            //FOREIGN KEYS ADD
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_medias');
    }
}
