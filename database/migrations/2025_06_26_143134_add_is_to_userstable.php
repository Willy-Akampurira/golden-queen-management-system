<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations — add 'role' to users table
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add role column (string), with a default role if needed
            $table->string('role')->default('user')->after('email');
        });
    }

    /**
     * Reverse the migrations — drop 'role' column
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
