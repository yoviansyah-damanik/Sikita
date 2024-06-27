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
        Schema::create('guidance_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guidance_id')
                ->references('id')
                ->on('guidances')
                ->onDelete('cascade');
            $table->text('message');
            $table->enum('type', ['success', 'error', 'warning']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guidance_histories');
    }
};
