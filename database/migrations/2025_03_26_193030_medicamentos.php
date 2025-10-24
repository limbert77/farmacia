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
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->boolean('requiere_receta')->default(false);
            $table->foreignId('id_proveedor')->constrained('proveedores')->onDelete('cascade');
            $table->date('fecha_vencimiento')->nullable();
            $table->enum('categoria', ['analgésico', 'antibiótico', 'antigripal', 'antiinflamatorio', 'otro']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};
