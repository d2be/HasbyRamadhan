<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMahasiswaTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_mahasiswa', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('jurusan');
            $table->string('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_mahasiswa');
    }
}