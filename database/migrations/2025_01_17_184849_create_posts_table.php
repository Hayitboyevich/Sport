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
        Schema::create('posts', function (Blueprint $table) {
            $table->id('post_id');
            $table->bigInteger('post_menu_id');
            $table->string('post_title');
            $table->string('post_slug')->nullable();
            $table->string('post_image')->nullable();
            $table->string('post_desc')->nullable();
            $table->string('post_content')->nullable();
            $table->date('post_date')->nullable();
            $table->integer('post_type')->default(0);
            $table->integer('post_status')->default(0);
            $table->bigInteger('post_view')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
