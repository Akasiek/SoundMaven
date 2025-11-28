<?php

use App\Models\AlbumReview;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove deleted records before removing columns
        try {
            AlbumReview::onlyTrashed()->forceDelete();
        } catch (Exception) {
            DB::query()->from('album_reviews')->whereNotNull('deleted_at')->delete();
        }

        Schema::table('album_reviews', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('album_reviews', function (Blueprint $table) {
            $table->softDeletes();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }
};
