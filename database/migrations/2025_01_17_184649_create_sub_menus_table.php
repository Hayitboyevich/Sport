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
        Schema::create('sub_menus', function (Blueprint $table) {
            $table->id('sub_menu_id');
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->string('sub_title_uz');
            $table->string('sub_title_ru');
            $table->string('sub_title_en');
            $table->integer('sub_type')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_menus');
    }
};
