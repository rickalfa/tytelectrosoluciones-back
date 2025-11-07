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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();


            // --- Columnas de nuestro formulario ---
            $table->string('nombre'); // Columna para el nombre (texto corto)
            $table->string('email');  // Columna para el email (texto corto)
            $table->string('telefono')->nullable(); // Columna para el teléfono (texto corto)
            $table->text('mensaje'); // Columna para el mensaje (texto largo)
            // ------------------------------------

            // --- Columnas para el Doble Opt-in (Opción B) ---
            $table->string('verification_token')->nullable()->unique(); // Guarda el token único
            $table->timestamp('email_verified_at')->nullable(); // Guarda la fecha de verificación
            // -

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
