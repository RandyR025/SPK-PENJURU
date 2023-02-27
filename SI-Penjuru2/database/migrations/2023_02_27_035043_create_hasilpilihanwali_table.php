<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilpilihanwaliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasilpilihanwali', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pilihan');
            $table->string('kode_pengisian');
            $table->foreignId('user_id_wali')->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('user_id_guru')->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('kode_pilihan')
            ->references('kode_pilihan')
            ->on('pilihan')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('kode_pengisian')
            ->references('kode_pengisian')
            ->on('pengisian')
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
        Schema::dropIfExists('hasilpilihanwali');
    }
}
