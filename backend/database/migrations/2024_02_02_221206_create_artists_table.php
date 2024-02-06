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
        Schema::create('artists', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name', 255);
            $table->string('slug', 511)->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['band', 'solo', 'duo', 'other']);

            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
