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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Article title');
            $table->string('slug')->comment('For clean and SEO friendly parameter route article');
            $table->string('summary')->comment('Summary of article');
            $table->text('content')->comment('Content of article');
            $table->string('thumbnail')->nullabl()->comment('Thumbnail of article');
            $table->boolean('is_published')->default(false)->comment('Flag of published article, its used for draft the article');
            $table->dateTime('published_at')->nullable()->comment('The time of published');

            // RELATIONS
            $table->foreignId('created_by')
                ->nullable()
                ->comment('Flag of creator')
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
