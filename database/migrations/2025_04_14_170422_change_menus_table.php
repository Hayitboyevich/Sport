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
        Schema::table('menus', function (Blueprint $table) {
            $table->string('title_uz')->nullable()->change();
            $table->string('title_ru')->nullable()->change();
            $table->string('title_en')->nullable()->change();
        });

        Schema::table('sub_menus', function (Blueprint $table) {
            $table->string('sub_title_uz')->nullable()->change();
            $table->string('sub_title_ru')->nullable()->change();
            $table->string('sub_title_en')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
