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
        Schema::table('students', function (Blueprint $table) {
            $table->string('email')->nullable()->after('name');
            $table->string('guardian_email')->nullable()->after('email');
        });

        Schema::table('school_classes', function (Blueprint $table) {
            $table->boolean('is_multigrade')->default(false)->after('name');
            $table->json('grades_covered')->nullable()->after('is_multigrade');
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->string('bncc_skill_code')->nullable()->index()->after('score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['email', 'guardian_email']);
        });

        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn(['is_multigrade', 'grades_covered']);
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('bncc_skill_code');
        });
    }
};
