<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Classes
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('year')->nullable();
            $table->string('subject')->nullable();
            $table->boolean('is_multigrade')->default(false);
            $table->json('grades_covered')->nullable();
            $table->timestamps();
        });

        // 2. Students
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('registration_number')->nullable();
            $table->timestamps();
        });

        // 3. Attendances
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->date('date');
            $table->string('status')->nullable(); // present, absent, late, etc.
            $table->text('observation')->nullable();
            $table->timestamps();
        });

        // 4. Grades
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->integer('cycle')->nullable();
            $table->integer('evaluation_number')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->string('bncc_skill_code')->nullable()->index();
            $table->timestamp('locked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('students');
        Schema::dropIfExists('classes');
    }
};
