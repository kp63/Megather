<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->json('details');
            $table->string('content', 1000);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->engine = 'InnoDB';
        });
//        Schema::create('posts_trash', function (Blueprint $table) {
//            $table->string('reason');
//            $table->integer('id');
//            $table->integer('user_id');
//            $table->json('details');
//            $table->string('content', 1000);
//            $table->timestamp('created_at');
//
//            $table->engine = 'InnoDB';
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('posts_trash');
    }
}
