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
            // id, titulo, texto, (imagen,) autor(user-id), fecha
            $table->id();

            $table->string('title', 200);
            $table->text('text');
            $table->string('image', 200)->nullable();
            $table->BigInteger('user_id')->unsigned(); //autor //unsigned->Positivos
            $table->date('date');
            $table->time('time');

            $table->timestamps();

            //foráneas
            $table->foreign('user_id')->references('id')->on('users'); //referencia al modelo USER de usuarios

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
