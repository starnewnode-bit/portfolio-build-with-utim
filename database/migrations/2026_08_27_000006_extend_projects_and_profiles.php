<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom yang dipakai oleh controller & view:
     *  - projects: is_published, published_at (untuk filter listing)
     *  - profiles: bio_long, extras (untuk halaman About detail)
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('is_published')->default(true)->after('is_featured');
            $table->timestamp('published_at')->nullable()->after('is_published');
            // Index untuk query listing
            $table->index(['is_published', 'published_at']);
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->text('bio_long')->nullable()->after('bio');
            $table->json('extras')->nullable()->after('cv_url'); // education, certifications, languages
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'published_at']);
            $table->dropColumn(['is_published', 'published_at']);
        });
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['bio_long', 'extras']);
        });
    }
};
