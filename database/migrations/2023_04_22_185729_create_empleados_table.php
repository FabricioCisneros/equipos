<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('apellidos');
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->foreignId('oficina_id')->nullable()->constrained('oficinas')->nullOnDelete();
            $table->foreignId('turno_id')->constrained('turnos');
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
        Schema::table('empleados', function (Blueprint $table) {
            $table->dropForeign(['oficina_id']);
            $table->dropForeign(['turno_id']);
        });
    }
}
