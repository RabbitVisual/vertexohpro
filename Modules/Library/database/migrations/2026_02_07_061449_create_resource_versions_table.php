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
        Schema::create('resource_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('library_resource_id')->constrained()->cascadeOnDelete();
            $table->string('version');
            $table->string('file_path');
            $table->text('changelog')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_versions');
    }
};
