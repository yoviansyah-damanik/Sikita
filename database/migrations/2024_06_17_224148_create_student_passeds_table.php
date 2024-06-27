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
        Schema::create('student_passeds', function (Blueprint $table) {
            $table->id();
            $table->char('student_id', 9);
            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');
            $table->string('semester', 2);
            $table->year('year');
            $table->enum('grade', ['A', 'B', 'C', 'D', 'E']);
            $table->integer('grade_poin')
                ->min(0)
                ->max(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_passeds');
    }
};
