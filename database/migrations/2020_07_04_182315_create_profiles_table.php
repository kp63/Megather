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
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('nickname')->nullable();
            $table->string('avatar_provider')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('bio', 2000)->nullable();
            $table->json('links')->nullable();
            $table->string('discord_id')->nullable();
            $table->timestamp('discord_id_updated_at')->nullable();
            $table->boolean('publish_discord_id')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
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
