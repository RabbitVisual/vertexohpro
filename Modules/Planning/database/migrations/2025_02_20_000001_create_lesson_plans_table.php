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
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_class_id')->nullable()->constrained('school_classes')->onDelete('set null');
            $table->string('title');
            $table->enum('template_type', ['standard', 'active', 'synthetic'])->default('standard');
            $table->json('content')->nullable(); // Stores sections: Introduction, Development, Assessment
            $table->json('bncc_codes')->nullable(); // Array of BNCC codes used
            $table->json('sections')->nullable(); // Dynamic sections from Jules' branch
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_plans');
    }
};
