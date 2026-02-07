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
        Schema::create('cycle_closures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->unsignedTinyInteger('cycle');
            $table->longText('signature'); // Base64 signature
            $table->timestamp('signed_at');
            $table->timestamps();

            // Ensure one closure per class per cycle
            $table->unique(['class_id', 'cycle']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cycle_closures');
    }
};
