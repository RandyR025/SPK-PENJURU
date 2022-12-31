<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePvKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pv_kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('id_kriteria')->nullable();
            $table->string('nilai_kriteria')->nullable();
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
        Schema::dropIfExists('pv_kriteria');
    }
}
