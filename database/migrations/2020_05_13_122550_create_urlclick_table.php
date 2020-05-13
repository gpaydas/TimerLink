<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlclickTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urlclick', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ipadress');
            $table->bigInteger('url_id')->unsigned();
            $table->timestamps();
            $table->foreign('url_id')->references('id')->on('url')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urlclick');
    }
}
