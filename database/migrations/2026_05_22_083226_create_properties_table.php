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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')
                ->constrained('agents')
                ->restrictOnDelete();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->text('description')->nullable();
            $table->enum('type', [
                'apartment',
                'villa',
                'studio',
                'penthouse',
                'townhouse',
                'commercial',
                'land',
                'farmhouse',
                'cottage',
                'loft',
                'duplex',
                'triplex',
                'ranch',
                'mobile_home',
                'condo',
                'bungalow',
                'castle',
            ])->index();
            $table->enum('status', [
                'for_rent',
                'for_sale',
                'sold',
                'rented',
                'off_market',
            ])->default('for_sale')->index();
            $table->unsignedBigInteger('price')->comment('Price in cents for precision');
            $table->unsignedInteger('surface')->nullable();
            $table->unsignedTinyInteger('bedrooms')->default(0);
            $table->unsignedTinyInteger('bathrooms')->default(0);
            $table->unsignedTinyInteger('floors')->nullable();
            $table->unsignedSmallInteger('year_built')->nullable();
            $table->string('address', 255);
            $table->string('city', 100)->index();
            $table->string('state', 100)->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->string('country', 80)->default('US');
            // $table->decimal('latitude', 10, 7)->nullable();
            // $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_published')->default(true)->index();
            // $table->unsignedInteger('views_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};