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
        Schema::create('article_tags', function (Blueprint $table) {
            $table->id();

            // RELATIONS
            $table->foreignId('article_id')
                ->nullable()
                ->comment('Relation of article key')
                ->constrained('articles')
                ->cascadeOnDelete();

            $table->foreignId('tag_id')
                ->nullable()
                ->comment('Relation of tag key')
                ->constrained('tags')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_tags');
    }
};
