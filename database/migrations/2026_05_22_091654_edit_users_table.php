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
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name', 80);
            $table->string('phone', 30)->nullable();
            $table->string('avatar')->nullable();
            $table->enum('role', ['admin', 'agent', 'buyer'])->default('buyer')->index();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->removeColumn('last_name');
            $table->removeColumn('phone');
            $table->removeColumn('avatar');
            $table->removeColumn('role');
            $table->dropSoftDeletes();
        });
    }
};