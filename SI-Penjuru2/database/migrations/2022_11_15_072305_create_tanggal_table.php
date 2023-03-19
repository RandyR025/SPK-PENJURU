<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanggalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanggal', function (Blueprint $table) {
            $table->id();
            $table->string('id_penilaian');
            $table->foreign('id_penilaian')
            ->references('id_penilaian')
            ->on('penilaian')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->date('tanggal');
            $table->date('deadline');
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
        Schema::dropIfExists('tanggal');
    }
}
