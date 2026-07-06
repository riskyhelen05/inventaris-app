<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::table('borrowings', function (Blueprint $table) {
        if (!Schema::hasColumn('borrowings', 'status')) {
            $table->enum('status', ['pending', 'approved', 'returned'])
                  ->default('pending');
        }
    });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            //
        });
    }
};
