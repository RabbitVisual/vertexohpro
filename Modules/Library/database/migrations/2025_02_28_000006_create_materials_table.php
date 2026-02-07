<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('file_path');
            $table->decimal('price', 8, 2)->nullable();
            $table->json('tags')->nullable(); // Using json column for tags for simplicity or should create tag table?
            // Plan said material_tags separately but for simplicity let's stick to json or text if not many to many complex.
            // Wait, "sistema de tags" implies searchability. Let's create a separate table if needed or just use simple storage.
            // Let's create a separate table for tags to be proper.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
