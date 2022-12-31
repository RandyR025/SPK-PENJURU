<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerbandinganKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perbandingan_kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('kriteria_pertama')->nullable();
            $table->string('value')->nullable();
            $table->string('kriteria_kedua')->nullable();
            $table->foreign('kriteria_pertama')
            ->references('kode_kriteria')
            ->on('kriteria')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('kriteria_kedua')
            ->references('kode_kriteria')
            ->on('kriteria')
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
        Schema::dropIfExists('perbandingan_kriteria');
    }
}
