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
        Schema::table('food', function (Blueprint $table) {
            $table->text('location')->nullable();
            $table->date('expiration_date')->nullable();
            $table->text('qty_unit')->nullable();
            $table->text('buy_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('food', function (Blueprint $table) {
            $table->dropColumn('location');
            $table->dropColumn('expiration_date');
            $table->dropColumn('qty_unit');
            $table->dropColumn('buy_at');
        });
    }
};
