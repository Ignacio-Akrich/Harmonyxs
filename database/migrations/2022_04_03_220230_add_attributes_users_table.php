<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('music_genre');
            $table->string('age');
            $table->text('description')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('header_photo')->nullable();
            $table->string('telephone')->nullable();
            $table->string('availability_table')->nullable();
            //datos artista
            $table->string('experience')->nullable();
            $table->boolean('band_experience')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            //datos banda
            $table->string('member')->nullable();
            $table->boolean('concert_experience')->nullable();
            $table->date('creation_date')->nullable();
            $table->string('address_rehearsal_room')->nullable();
            $table->string('address')->nullable();
            $table->decimal('lat', 10, 4)->nullable();
            $table->decimal('lng', 10, 4)->nullable();

            $table->foreignId('instrument_id')->nullable()->constrained('instruments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('social_media_id')->nullable()->constrained('social_medias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('published_ad_id')->nullable()->constrained('ads')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('saved_ad_id')->nullable()->constrained('ads')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
