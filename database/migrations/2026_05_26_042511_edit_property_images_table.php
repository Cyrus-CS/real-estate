<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. property_images : supprimer dans le bon ordre ──
        Schema::table('property_images', function (Blueprint $table): void {
            // 1a. Supprimer la foreign key en premier
            $table->dropForeign(['property_id']);

            // 1b. Supprimer l'index unique composite (libéré car FK supprimée)
            $table->dropUnique('unique_cover_per_property');

            // 1c. Supprimer l'index simple sur is_cover
            $table->dropIndex('property_images_is_cover_index');

            // 1d. Supprimer la colonne is_cover
            $table->dropColumn('is_cover');

            // 1e. Remettre la foreign key
            $table->foreign('property_id')
                ->references('id')
                ->on('properties')
                ->cascadeOnDelete();
        });

        // ── 2. properties : ajouter cover_image ───────────────
        Schema::table('properties', function (Blueprint $table): void {
            $table->string('cover_image')->nullable()->after('year_built');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table): void {
            $table->dropColumn('cover_image');
        });

        Schema::table('property_images', function (Blueprint $table): void {
            $table->dropForeign(['property_id']);

            $table->boolean('is_cover')->default(false)->index();
            $table->unique(['property_id', 'is_cover'], 'unique_cover_per_property');

            $table->foreign('property_id')
                ->references('id')
                ->on('properties')
                ->cascadeOnDelete();
        });
    }
};