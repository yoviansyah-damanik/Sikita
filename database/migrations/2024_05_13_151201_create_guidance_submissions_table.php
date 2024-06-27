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
        Schema::create('guidance_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guidance_id')
                ->references('id')
                ->on('guidances')
                ->onDelete('cascade');
            $table->string('title');
            $table->string('filename');
            $table->string('filepath');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guidance_submissions');
    }
};
