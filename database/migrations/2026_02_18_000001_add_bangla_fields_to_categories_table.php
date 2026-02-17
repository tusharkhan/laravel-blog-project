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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->string('slug_bn')->nullable()->after('slug');
            $table->longText('description_bn')->nullable()->after('description');
            $table->dropColumn('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'title_bn',
                'slug_bn',
                'description_bn',
            ]);
            $table->string('image')->nullable()->default(null);
        });
    }
};

