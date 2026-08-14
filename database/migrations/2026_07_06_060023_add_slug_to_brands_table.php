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
        if (!Schema::hasColumn('brands', 'slug')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('name');
            });

            // Populate existing rows
            $brands = \Illuminate\Support\Facades\DB::table('brands')->get();
            foreach ($brands as $brand) {
                \Illuminate\Support\Facades\DB::table('brands')
                    ->where('id', $brand->id)
                    ->update(['slug' => \Illuminate\Support\Str::slug($brand->name)]);
            }

            Schema::table('brands', function (Blueprint $table) {
                $table->string('slug')->nullable(false)->change();
                $table->unique('slug');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('brands', 'slug')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            });
        }
    }
};
