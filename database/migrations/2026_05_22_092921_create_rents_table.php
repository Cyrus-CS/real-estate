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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')
                ->constrained('properties')
                ->cascadeOnDelete();
            $table->foreignId('applicant_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->enum('status', [
                'pending',
                'under_review',
                'approved',
                'rejected',
                'cancelled',
            ])->default('pending')->index();
            $table->text('message')->nullable()->comment('Applicant cover message');
            $table->text('rejection_reason')->nullable();
            $table->date('desired_move_in')->nullable();
            $table->unsignedSmallInteger('lease_duration_months')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();

            // One open application per applicant per property
            $table->unique(
                ['property_id', 'applicant_id', 'status'],
                'unique_open_application'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};