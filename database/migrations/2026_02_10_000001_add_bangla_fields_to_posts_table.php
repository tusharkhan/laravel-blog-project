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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->string('slug_bn')->nullable()->after('slug');
            $table->longText('content_bn')->nullable()->after('content');
            $table->string('publisher_bn')->nullable()->after('publisher');
            $table->string('reporter_bn')->nullable()->after('reporter');
            $table->string('location_bn')->nullable()->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'title_bn',
                'slug_bn',
                'content_bn',
                'publisher_bn',
                'reporter_bn',
                'location_bn',
            ]);
        });
    }
};
