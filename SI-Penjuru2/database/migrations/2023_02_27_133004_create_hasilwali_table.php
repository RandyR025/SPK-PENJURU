<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilwaliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasilwali', function (Blueprint $table) {
            $table->id();
            $table->string('totals');
            $table->foreignId('user_id_wali')->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('user_id_guru')->constrained()
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
        Schema::dropIfExists('hasilwali');
    }
}
