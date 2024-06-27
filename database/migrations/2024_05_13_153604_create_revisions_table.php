<?php

use App\Enums\RevisionStatus;
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
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guidance_id')
                ->references('id')
                ->on('guidances')
                ->onDelete('cascade');
            $table->char('lecturer_id', 10);
            $table->foreign('lecturer_id')
                ->references('id')
                ->on('lecturers');
            $table->string('title');
            $table->text('explanation');
            $table->enum('status', RevisionStatus::names())
                ->default(RevisionStatus::onProgress->name);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisions');
    }
};
