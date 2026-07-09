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
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->string('kode_barang', 50)->unique();

            $table->string('name', 150);

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('stock')
                ->default(0)
                ->index();

            $table->string('location', 100);

            $table->enum('condition', [
                'baik',
                'rusak'
            ])->index();

            $table->string('image')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};