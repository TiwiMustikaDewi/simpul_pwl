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
        Schema::create('sidang_kps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->onDelete('cascade');
            $table->dateTime('sidang_date')->nullable();
            $table->string('room')->nullable();
            $table->enum('status', ['submitted', 'scheduled', 'completed', 'rejected'])->default('submitted');
            $table->string('grade')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidang_kps');
    }
};
