<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspecciones', function (Blueprint $table) {
            $table->id();
            $table->string('cliente');
            $table->string('contenedor', 11)->index();
            $table->string('tipo', 10);
            $table->string('servicio');
            $table->string('depot');
            $table->double('dano')->default(0);
            $table->date('fecha_recepcion')->nullable();
            $table->date('fecha_inspeccion')->nullable();
            $table->date('reporte_sv')->nullable();
            $table->date('envio_cliente')->nullable();
            $table->text('comentarios')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspecciones');
    }
};
