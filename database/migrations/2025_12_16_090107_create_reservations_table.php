<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table déjà créée par 2026_04_09_182618_create_reservations_table.php
        // Cette migration est ignorée pour éviter le doublon
        if (!Schema::hasTable('reservations')) {
            Schema::create('reservations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->date('date');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Ne rien faire
    }
};
