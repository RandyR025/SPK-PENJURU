<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil', function (Blueprint $table) {
            $table->id();
            $table->string('totals');
            $table->bigInteger('tanggal_id')->unsigned();
            $table->foreignId('user_id')->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('id_penilaian');
            $table->foreign('id_penilaian')
            ->references('id_penilaian')
            ->on('penilaian')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('tanggal_id')
            ->references('id')
            ->on('tanggal')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
        Schema::dropIfExists('hasil');
    }
}
