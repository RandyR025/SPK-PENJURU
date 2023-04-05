<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('slider1');
            $table->string('slider2');
            $table->string('slider3');
            $table->string('bobot_guru');
            $table->string('bobot_wali');
            $table->string('bobot_kepsek_guru');
            $table->string('bobot_kepsek_walas');
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
        Schema::dropIfExists('custom');
    }
}
