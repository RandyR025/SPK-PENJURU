<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerbandinganSubkriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perbandingan_subkriteria', function (Blueprint $table) {
            $table->id();
            $table->string('subkriteria_pertama')->nullable();
            $table->string('value')->nullable();
            $table->string('subkriteria_kedua')->nullable();
            $table->string('id_kriteria')->nullable();
            $table->foreign('subkriteria_pertama')
            ->references('kode_subkriteria')
            ->on('subkriteria')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('subkriteria_kedua')
            ->references('kode_subkriteria')
            ->on('subkriteria')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('id_kriteria')
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
        Schema::dropIfExists('perbandingan_subkriteria');
    }
}
