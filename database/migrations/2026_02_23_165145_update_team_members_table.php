<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * FIXES:
     * - Removed duplicate `bio` column (already exists in original migration)
     * - Removed duplicate `image_url` change (already nullable in original)
     * - Added only truly new columns: phone, email, designation, twitter_url, experience
     * - Used ->after() for proper column ordering
     */
    public function up(): void
    {
        Schema::table('team_members', function (Blueprint $table) {

            // Modify existing columns safely
            $table->string('image_url')->nullable()->change();
            $table->string('instagram_url')->nullable()->change();
            $table->string('facebook_url')->nullable()->change();
            $table->boolean('is_active')->default(1)->change();

            // Add new columns (only ones not in original migration)
            $table->string('designation')->nullable()->after('name');
            $table->string('email')->nullable()->after('designation');
            $table->string('phone')->nullable()->after('email');
            $table->string('twitter_url')->nullable()->after('facebook_url');
            $table->integer('experience')->nullable()->after('twitter_url');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['designation', 'email', 'phone', 'twitter_url', 'experience']);
        });
    }
};