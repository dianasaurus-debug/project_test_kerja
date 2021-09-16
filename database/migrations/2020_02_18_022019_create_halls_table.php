<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->string('foto_gedung')->nullable();
            $table->string('nama_gedung');
            $table->string('kondisi_gedung');
            $table->longText('deskripsi');
            $table->date('tanggal_dibangun');
            $table->unsignedInteger('campus_id');

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
        Schema::dropIfExists('halls');
    }
}
