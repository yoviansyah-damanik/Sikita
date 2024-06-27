<?php

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
        Schema::create('guidance_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guidance_group_id')
                ->references('id')
                ->on('guidance_groups')
                ->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->integer('order')
                ->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guidance_types');
    }
};
