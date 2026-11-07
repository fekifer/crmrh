<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('CTS_TIPOS_SESION', function (Blueprint $table) {

            $table->bigIncrements('ID_TIPO_SESION');
            $table->string('TIPO_SESION', 64);
            $table->dateTime('FECHA_CREACION');
            $table->dateTime('FECHA_MODIFICACION');
            $table->integer('ID_USUARIO');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('CTS_TIPOS_SESION');
    }
};