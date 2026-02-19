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
        // Add new fields to media table
        Schema::table('media', function (Blueprint $table) {
            $table->string('title')->nullable()->after('user_id');
            $table->string('title_bn')->nullable()->after('title');
            $table->text('description')->nullable()->after('title_bn');
            $table->text('description_bn')->nullable()->after('description');
            $table->string('location')->nullable()->after('description_bn');
            $table->string('location_bn')->nullable()->after('location');
        });

        // Create media_files table for multiple images per media entry
        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->constrained('media')->onDelete('cascade');
            $table->string('file_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_files');

        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn(['title', 'title_bn', 'description', 'description_bn', 'location', 'location_bn']);
        });
    }
};
