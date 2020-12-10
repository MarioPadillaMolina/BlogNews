<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            // id, idnoticia, texto, fecha, correo
            $table->id();

            $table->BigInteger('post_id')->unsigned();
            $table->text('text');
            $table->string('email');

            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts'); //referencia al modelo USERS de usuarios
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
