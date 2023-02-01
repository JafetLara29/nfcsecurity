<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_o_s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('oficial_id');
            $table->integer('checked')->default(false);
            $table->bigInteger('user_id')->unsigned();//id del usuario de la organizacion
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_o_s');
    }
};
