<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('pretty_name');
            $table->string('bio');
//            $table->string('');
            $table->integer('owner_user_id');
            $table->integer('leader_user_id');
            $table->integer('sub_leader_user_id');
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
        Schema::dropIfExists('clans');
    }
}
