<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id')->nullable();

            $table->string('name', 255);
            $table->string('slug', 511)->unique();
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
        });

        // Add foreign key for parent_id after table creation
        Schema::table('genres', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('genres')->nullOnDelete();
        });

        // Many-to-Many relationship with albums
        Schema::create('album_genre', function (Blueprint $table) {
            $table->foreignUuid('album_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('genre_id')->constrained()->cascadeOnDelete();

            $table->primary(['album_id', 'genre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_genre');
        Schema::dropIfExists('genres');
    }
};
