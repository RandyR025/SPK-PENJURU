<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengisianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengisian', function (Blueprint $table) {
            $table->string('kode_pengisian')->primary();
            $table->string('nama_pengisian');
            $table->string('kode_subkriteria');
            $table->foreign('kode_subkriteria')
            ->references('kode_subkriteria')
            ->on('subkriteria')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('id_penilaian');
            $table->foreign('id_penilaian')
            ->references('id_penilaian')
            ->on('penilaian')
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
        Schema::dropIfExists('pengisian');
    }
}
