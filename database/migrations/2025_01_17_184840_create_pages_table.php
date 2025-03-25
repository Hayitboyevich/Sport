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
        Schema::create('pages', function (Blueprint $table) {
            $table->id('page_id');
            $table->bigInteger('page_menu_id')->unsigned();
            $table->string('page_title');
            $table->string('page_slug')->nullable();
            $table->text('page_content')->nullable();
            $table->string('page_image')->nullable();
            $table->bigInteger('page_view')->default(0)->comment("Ko'rishlar soni");
            $table->date('page_date');
            $table->integer('page_type')->default(0);
            $table->boolean('page_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
