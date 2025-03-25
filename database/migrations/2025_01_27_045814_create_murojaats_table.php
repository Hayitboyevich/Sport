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
        Schema::create('murojaats', function (Blueprint $table) {
            $table->id('murojaat_id');
            $table->string('f_i_sh');
            $table->date('birth_day');
            $table->string('email')->nullable();
            $table->integer('type')->comment("qanday masala yuzasidan murojaat");
            $table->string('phone_number');
            $table->text('murojaat_text');
            $table->integer('offerta');
            $table->integer('status')->default(0);
            $table->integer('answered_user')->default(0);
            $table->date('answered_date')->nullable();
            $table->text('answered_text')->nullable();
            $table->string('answered_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('murojaats');
    }
};
