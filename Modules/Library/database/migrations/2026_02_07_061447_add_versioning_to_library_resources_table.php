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
        Schema::table('library_resources', function (Blueprint $table) {
            $table->string('version')->default('1.0')->after('file_path');
            $table->timestamp('free_until')->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('library_resources', function (Blueprint $table) {
            $table->dropColumn(['version', 'free_until']);
        });
    }
};
