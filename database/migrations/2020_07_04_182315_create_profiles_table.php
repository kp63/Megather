<?php

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
            $table->integer('id')->primary();
            $table->string('nickname')->nullable();
            $table->string('avatar_provider')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('bio', 2000)->nullable();
            $table->json('links')->nullable();
            $table->boolean('publish_discord_id')->default(false);
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
        Schema::dropIfExists('profiles');
    }
}
