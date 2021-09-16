<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('foto_ruang')->nullable();
            $table->string('nama_ruang');
            $table->string('kondisi_ruang');
            $table->unsignedInteger('gedung_id');
            $table->date('tanggal_dibangun');
            $table->longText('deskripsi');

            //FOREIGN KEY CONSTRAINTS
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
        Schema::dropIfExists('rooms');
    }
}
