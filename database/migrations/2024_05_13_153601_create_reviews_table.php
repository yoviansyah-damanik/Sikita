<?php

use App\Enums\SupervisorType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guidance_id')
                ->references('id')
                ->on('guidances')
                ->onDelete('cascade');
            $table->char('lecturer_id', 10);
            $table->foreign('lecturer_id')
                ->references('id')
                ->on('lecturers');
            $table->text('review');
            $table->enum('status', ['approved', 'revision']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
