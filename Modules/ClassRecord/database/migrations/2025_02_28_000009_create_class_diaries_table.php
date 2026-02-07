<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_diaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('lesson_plan_id')->nullable()->constrained('lesson_plans')->onDelete('set null'); // Optional link
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->text('content')->nullable(); // Diary content
            $table->json('bncc_skills')->nullable(); // Snapshot of used skills
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_diaries');
    }
};
