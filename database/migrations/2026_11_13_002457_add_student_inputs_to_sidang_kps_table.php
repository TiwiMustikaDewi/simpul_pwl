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
        Schema::table('sidang_kps', function (Blueprint $table) {
            $table->dateTime('proposed_date')->nullable()->after('internship_id');
            $table->string('presentation_file')->nullable()->after('room');
            $table->text('student_notes')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sidang_kps', function (Blueprint $table) {
            $table->dropColumn(['proposed_date', 'presentation_file', 'student_notes']);
        });
    }
};
